<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ilan_Model extends CI_Model {

 function __construct() {
        parent::__construct();
        $total_rows;
    }
    
    /**
     * Firma Categorileri getirir
     * @param int $id Category id si
     * @return object 
     */
    function getCategories(){
       $query = $this->db->query("SELECT id,name FROM site_ilan_category WHERE meslek='".$this->meslekid."'");
       return $query->result();
    }
    
    function getCategoriesDropDown($meslekid){
        $data=array();
       $query = $this->db->query("SELECT id,name FROM site_ilan_category WHERE meslek='".$this->meslekid."'");
       foreach($query->result() as $row){
           $data[$row->id]=$row->name;
       }
       return $data;
    }
    
    function getIlans($meslekid){
       $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        
        if(isset($_GET["ilantarihi"]) && $_GET["ilantarihi"]!=""){
            switch ($_GET["ilantarihi"]){
                case "1":
                   $cond.=" AND DATE(savedate) = CURDATE()";
                    break;
                case "2":
                    $cond.="AND DATE(savedate) BETWEEN SYSDATE() - INTERVAL 3 DAY AND SYSDATE()";
                    break;
                case "3":
                    $cond.="AND DATE(savedate) BETWEEN SYSDATE() - INTERVAL 7 DAY AND SYSDATE()";
                    break;
                case "4":
                    $cond.="AND DATE(savedate) BETWEEN SYSDATE() - INTERVAL 15 DAY AND SYSDATE()";
                    break;
                  case "5":
                    $cond.="AND DATE(savedate) BETWEEN SYSDATE() - INTERVAL 30 DAY AND SYSDATE()";
                    break;
            }
        }
        
        if(isset($_GET["il"]) && $_GET["il"]!=""){
            $cond.=" AND il='".$_GET["il"]."'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $cond.="AND category='".$_GET["category"]."'";
        }
        $cond="WHERE meslek='".$this->meslekid."' AND active='1' ".$cond;
        
       
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("ilan_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("ilan_rowperpage");
        }
      
       $sql="SELECT * FROM site_ilan_view";
       
       $query = $this->db->query($sql." ".$cond." ORDER BY savedate DESC");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit); 
       return $query2->result();
    }
    
    function getIlan($id){
        $query=$this->db->query("SELECT * FROM site_ilan_view WHERE id='".intval($id)."'");
        if($query->num_rows()>0) {
             return $query->row();
        } else {
            show_404();
        }
       
    }
  
    function ilanlarim(){
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("ilan_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("ilan_rowperpage");
        }
      
       $sql="SELECT * FROM site_ilan_view WHERE user_id='".$this->session->userdata("user_id")."'";
       
       $query = $this->db->query($sql." ORDER BY savedate DESC");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ORDER BY savedate DESC ".$limit); 
       return $query2->result();
        
        
    }
    
    
    function delete($id) {
      $query = $this->db->query("DELETE FROM site_ilan WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
    
   
   function save(){ 
       $name=addslashes($this->input->post("name"));
       $description=addslashes($this->input->post("description"));
       $category=addslashes($this->input->post("category"));
       $il=$this->input->post("il");
       $ilce=$this->input->post("ilce");
       $iletisimvisible=$this->input->post("iletisimvisible");
       // kontroller
       if(trim($name) != ""){
            if(trim($description) != ""){
                if(trim($category) != ""){
                    //sorgu
                    $query = $this->db->query("INSERT INTO site_ilan VALUES ('','".$this->session->userdata("user_id")."','".$category."','".$name."','".$description."','1',NOW(),NOW(),'0','".$il."','".$ilce."','".$iletisimvisible."')");
                    //başarılı mı
                    if($this->db->insert_id()>0){
                        echo '{"success":"true"}';
                    } else {
                        echo '{"success":"false"}';
                    }
                }else{
                    echo '{"success":"false"}';
                }
            }else{
                echo '{"success":"false"}';
            }
       }else{
           echo '{"success":"false"}';
       } 
   }
   
   function editsave($id){
   
    $category   = addslashes($this->input->post("category"));
        $description= addslashes($this->input->post("description"));
        $name       = addslashes($this->input->post("name"));
        $active     = addslashes($this->input->post("active"));
        $il         =  $this->input->post("il");
        $ilce       =  $this->input->post("ilce");
        
        //kontroller
        if(trim($category) != ""){
            if(trim($description) != ""){
                    if(trim($name) != ""){
                                //kontroller tamam - kayıt başlasın
                                $query  = "UPDATE site_ilan ";
                                $query .= "SET ";
                                $query .= "category='".$category."', ";
                                $query .= "name='".$name."', ";
                                $query .= "description='".$description."', ";
                                $query .= "il='".$il."', ";
                                $query .= "ilce='".$ilce."', ";
                                $query .= "updatedate=NOW() ";
                                $query .= "";
                                $query .= " WHERE id='".$id."'";
                                $insert=$this->db->query($query);
                                echo ($this->db->affected_rows()>0) ? '{"success":"true"}' : '{"success":"false"}';
                                
                    }else{
                        //isim girmedi
                        echo '{"success":"false"}';
                    }
            }else{
                //detaylarını girmedi
                echo '{"success":"false"}';
            }            
        }else{
            //kategori girmedi
            echo '{"success":"false"}';
        }
    }
   
   
   function basvuruKaydet(){
       $ilan_id=$this->input->post("ilan_id");
       $user_id=$this->session->userdata["user_id"];
       $message=addslashes($this->input->post("message"));
       
       $query=$this->db->query("INSERT INTO site_ilan_basvuru VALUES ('','".$user_id."','".$ilan_id."',NOW(),'".$message."')");
       
       $owner=$this->db->query("SELECT uf_id FROM site_ilan WHERE id='".$ilan_id."'");
       $owner=$owner->row();
       $owner=$owner->uf_id;
       $messageHtml="<a href='".base_url()."ilanlar/detay/".$ilan_id."'>".$ilan_id." Numaralı ilan</a> için <a href='".base_url()."uyeler/detay/".$this->session->userdata["user_id"]."'>".$this->session->userdata["user_adsoyad"]."</a> başvuruda bulundu.";
       $messageHtml.="<br/>Mesaj : <br/>".$message;
       
       //Mesaj olarak da Kaydet
       $query2=$this->db->query("INSERT INTO site_messages VALUES ('','".$owner."','".$user_id."','".lang("İlan Başvurusu")."','".addslashes($messageHtml)."',NOW(),'0')");
       
       if($this->db->insert_id()>0){
           echo '{"success":"true"}';
       } else {
           echo '{"success":"false"}';
       }
   }
   
   function getOtherIlans($meslekID, $mevcutIlanID){
       $query  = "SELECT * ";
       $query .= "FROM `site_ilan_view` ";
       $query .= "WHERE `id`!=$mevcutIlanID ";
       $query .= "AND `meslek`=$meslekID ";
       $query .= "AND `category`=(SELECT `category` FROM `site_ilan_view` WHERE `id`=$mevcutIlanID) ";
       $query .= "ORDER BY `savedate` DESC ";
       $query .= "LIMIT 10 ";
             
       
       $select              = $this->db->query($query);
       $this->total_rows    = $select->num_rows();
       
       return $select->result();
   }
    

}
 
?>

