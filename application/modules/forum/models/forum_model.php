<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class forum_model extends CI_Model {
    public $total_rows;
    
    function __construct() {
        parent::__construct();
        
    }

    function getForums($urlname) {
        $data=array();
        $id=$this->returnId($urlname,1);
        $query = $this->db->query("SELECT * FROM site_forum WHERE type='1' AND meslek_id='".$id."' ORDER BY ord ASC");
        foreach($query->result() as $row){
            $data[$row->id]["name"]=$row->name;
            $query2=$this->db->query("SELECT * FROM site_forum WHERE forum_id='".$row->id."' AND type='2' ");
            if($query2->num_rows()>0){
                foreach($query2->result() as $row2 ){
                    $data[$row->id]["subforums"][$row2->id]["name"]=$row2->name;
                    $data[$row->id]["subforums"][$row2->id]["description"]=$row2->description;
                   
                    //Konu Sayıları
                    $query3=$this->db->query("SELECT id FROM site_forum_konu WHERE type='1' and forum_id='".$row2->id."'");
                    $query4=$this->db->query("SELECT k.id FROM site_forum_konu as k LEFT JOIN site_forum_konu as s ON k.konu_id=s.id WHERE k.forum_id='".$row2->id."' OR s.forum_id='".$row2->id."'");
                    $data[$row->id]["subforums"][$row2->id]["konu"]=$query3->num_rows();
                    $data[$row->id]["subforums"][$row2->id]["mesaj"]=$query4->num_rows();
                    
                    //Mesaj
                    $query5=$this->db->query("SELECT id,name,user_id FROM site_forum_konu WHERE forum_id='".$row2->id."' ORDER BY savedate DESC LIMIT 0,1 ");
                    $row5=$query5->row();
                   if(isset($row5) && count($row5)>0){
                    
                    $data[$row->id]["subforums"][$row2->id]["sonmesaj"]=$row5->name;
                    $data[$row->id]["subforums"][$row2->id]["sonmesajlink"]=$this->createUrl($row5->id, 3);
                    
                    $query6=$this->db->query("SELECT adsoyad FROM site_users WHERE id='".$row5->user_id."'");
                    $row6=$query6->row();
                    $data[$row->id]["subforums"][$row2->id]["sonmesajyazar"]=$row6->adsoyad;
                    $data[$row->id]["subforums"][$row2->id]["sonmesajyazarid"]=$row5->user_id;
                   }
                    
                }
            }
        }
        return $data;
    }
    
    function returnId($urlname="",$types="2"){
        
        $query = $this->db->query("SELECT id,name FROM site_meslek WHERE urlname='".$urlname."'");
        $row=$query->row();
        return ($types==1 ) ? $row->id : $row->name;
    }
    
    function returnName($urlname=""){
        
        $query = $this->db->query("SELECT id,name FROM site_meslek WHERE urlname='".$urlname."'");
        $row=$query->row();
        return $row->name;
    }
    
    
    function getTopics($id){
        $data=array();
        $cond="";
        
        //Alt Forum Bilgileri
        $query=$this->db->query("SELECT id,name,forum_id,description FROM site_forum WHERE id='".$id."'");
        $row=$query->row();
        $data["altforum"]["id"]=$row->id ;
        $data["altforum"]["name"]=$row->name;      
        $data["altforum"]["description"]=$row->description;      
        
        //Forum Bilgileri
        $query2=$this->db->query("SELECT id,name,meslek_id FROM site_forum WHERE id='".$row->forum_id."'");
        $row2=$query2->row();
        $data["forum"]["name"]=$row2->name;     
              
        //Meslek Bilgileri
    	$query3=$this->db->query("SELECT urlname,name FROM site_meslek WHERE id='".$row2->meslek_id."'");
        $row3=$query3->row();
        $data["meslek"]["name"]=$row3->name;      
        $data["meslek"]["url"]=$row3->urlname;   
               
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["harf"]) && $_GET["harf"]!=""){
            $cond.=" AND name like '".$_GET["harf"]."%'";
        }
        $cond="WHERE type='1' AND forum_id='".$id."' ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",10";
        } else {
            $limit="LIMIT 0,10";
        }
       
       $sql="SELECT * FROM site_forum_konu_view";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit." "); 
       $data["konular"]=$query2->result();
           
        return $data;
    }
    
    function getTopic($id){
        $query = $this->db->query("SELECT name,description FROM site_forum_konu WHERE id='".$id."' AND user_id='".$this->session->userdata("user_id")."'");
        return $query->row();
    }
        
    function saveTopic($id){
    	$name = addslashes($this->input->post("name"));
    	$description = addslashes($this->input->post("description"));
    	$forum_id= $id;
        
    	$query = $this->db->query("INSERT INTO site_forum_konu (name,description,forum_id,user_id,type,savedate) VALUES ('".$name."','".$description."','".$forum_id."','".$this->session->userdata("user_id")."','1',NOW())");
    	if($this->db->insert_id()>0){
            $link=$this->createUrl($this->db->insert_id(), 3);
    		echo '{"success":"true" , "link":"'.$link.'"}';
    	} else {
    		echo '{"success":"false","msg":"Hata : Konu Kaydedilemedi."}';
    	}
    
    }
    
    function editsaveTopic($id){
        $name = addslashes($this->input->post("name"));
    	$description = addslashes($this->input->post("description"));
    	$konu_id= $id;
       
        $query = $this->db->query("SELECT type,konu_id FROM site_forum_konu WHERE id='".$id."'");
        $row=$query->row();
        
        $query = $this->db->query("UPDATE site_forum_konu SET name='".$name."', description='".$description."' WHERE id='".$id."' AND user_id='".$this->session->userdata("user_id")."'");
    	if($this->db->affected_rows()>0){
            $link = ($row->type==1) ? $this->createUrl($id, 3) : $this->createUrl($row->konu_id, 3);
    		echo '{"success":"true" , "link":"'.$link.'"}';
    	} else {
    		echo '{"success":"false","msg":"Hata : Konu Kaydedilemedi."}';
    	}
        
    }
    
    function deleteTopic($id){
        $query = $this->db->query("SELECT id,type,konu_id,forum_id FROM site_forum_konu WHERE id='".$id."' AND user_id='".$this->session->userdata("user_id")."'");
        $row=$query->row();
        if($row->type==1){
            $query = $this->db->query("DELETE FROM site_forum_konu WHERE konu_id='".$id."' OR id='".$id."'");
            $link=$this->createUrl($row->forum_id, 2);        
        } else {
            $link=$this->createUrl($row->konu_id, 3);
            $query = $this->db->query("DELETE FROM site_forum_konu WHERE id='".$id."'");
            
        }
        if($this->db->affected_rows()>0){
            echo '{"success":"true","link":"'.$link.'"}';
        } else {
            echo '{"success":"false","msg":"Hata : Silinemedi"}';
        }
        
        
    }
    
    function saveReply($id){
    	$description = addslashes($this->input->post("description"));
    	$konu_id= $id;
        $link=$this->createUrl($id, 3);
    	$query = $this->db->query("INSERT INTO site_forum_konu (description,user_id,type,savedate,konu_id) VALUES ('".$description."','".$this->session->userdata("user_id")."','2',NOW(),'".$konu_id."')");
    	if($this->db->insert_id()>0){
    		echo '{"success":"true","link":"'.$link.'"}';
    	} else {
    		echo '{"success":"false","msg":"Hata : Konu Kaydedilemedi."}';
    	}        
    }
    
    
    function showTopic($id){
        $query = $this->db->query("SELECT * FROM site_forum_konu_view WHERE id='".$id."'");
        $row=$query->row();
        $data["konu"]=$row;
                
        //Alt Forum Bilgileri
        $query=$this->db->query("SELECT id,name,forum_id FROM site_forum WHERE id='".$row->forum_id."'");
        $row4=$query->row();
        $data["altforum"]["id"]=$row4->id ;
        $data["altforum"]["name"]=$row4->name;      
        
        //Forum Bilgileri
        $query2=$this->db->query("SELECT id,name,meslek_id FROM site_forum WHERE id='".$row4->forum_id."'");
        $row2=$query2->row();
        $data["forum"]["name"]=$row2->name;     
              
        //Meslek Bilgileri
    	$query3=$this->db->query("SELECT urlname,name FROM site_meslek WHERE id='".$row2->meslek_id."'");
        $row3=$query3->row();
        $data["meslek"]["name"]=$row3->name;      
        $data["meslek"]["url"]=$row3->urlname; 
        
        //Tüm Mesajlar
              
        $cond="WHERE id='".$id."' OR konu_id='".$id."'";
        
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",10";
        } else {
            $limit="LIMIT 0,10";
        }
       
       $sql="SELECT * FROM site_forum_konu_view";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY type ASC,savedate ASC ".$limit." "); 
       $data["mesajlar"]=$query2->result();
       return $data;
    }
    
    function createUrl($id,$type){
        switch ($type){
            case "1":
                break;
            case "2":
                $query=$this->db->query("SELECT id,name,forum_id FROM site_forum WHERE id='".$id."'");
                $row=$query->row();
                
                $query2=$this->db->query("SELECT meslek_id from site_forum WHERE id='".$row->forum_id."'");
                $row2=$query2->row();
                
                $query3=$this->db->query("SELECT name FROM site_meslek WHERE id='".$row2->meslek_id."'");
                $row3=$query3->row();
                
                return base_url()."".url_title($row3->name)."/forumlar/".url_title($row->name)."-".$row->id."f.html";
                        
                        
                break;
            case "3":
                $query=$this->db->query("SELECT id,name,meslek,forumname FROM site_forum_konu_view WHERE id='".$id."'");
                $row=$query->row();
                return base_url()."".url_title($row->meslek)."/forumlar/".url_title($row->forumname)."/".url_title($row->name)."-".$row->id."fk.html";
            break;
            
        }
    }
    
    function myTopics(){
        
        $cond="WHERE user_id='".$this->session->userdata("user_id")."' AND type='1'";
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",10";
        } else {
            $limit="LIMIT 0,10";
        }
       
       $sql="SELECT * FROM site_forum_konu_view";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit." "); 
       $data=$query2->result();
           
        return $data;
        
    }
}
?>
