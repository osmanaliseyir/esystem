<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class mod_ilan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getIlans($meslekid){
       $cond="";
       if(isset($_GET["id"]) && $_GET["id"]!=""){
                   $cond.=" AND v.id='".$_GET["id"]."'";

           
       } else {
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["active"]) && $_GET["active"]!=""){
            $cond.=" AND v.active='".$_GET["active"]."'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $cond.="AND category='".$_GET["category"]."'";
        } 
        
        } 
        $cond="WHERE v.meslek='".$this->meslekid."' ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("ilan_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("ilan_rowperpage");
        }
      
       $sql  = "SELECT v.*, u.adsoyad FROM site_ilan_view AS v ";
       $sql .= "LEFT JOIN site_users AS u ON (v.user_id = u.id) ";
       $query = $this->db->query($sql." ".$cond." ORDER BY v.savedate DESC");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY v.savedate DESC ".$limit); 
       return $query2->result();
    }
    
    function ilanOnaylaReddet(){
        $ilanID         = addslashes($this->input->post("id"));
        $active         = addslashes($this->input->post("active"));
        $islemYapanID   = addslashes($this->input->post("islemYapanID"));
        //kontrol
        $query          = "SELECT id FROM site_ilan WHERE id='".$ilanID."' ";
        $select         = $this->db->query($query);
        if($select->num_rows() > 0){
            //ilana işlemi ypıyoruz
            if($active == 1){
                $query  = "UPDATE site_ilan SET active='".$active."' WHERE id='".$ilanID."' ";
            }else{
                $query  = "DELETE FROM site_ilan WHERE id='".$ilanID."' ";
            }
            $select     = $this->db->query($query);
            echo '{"success":"true"}';
        }else{
            //böyle bir ilan yok ki
            echo '{"success":"false"}';
        }
    }
    
    function editsave($ilanID){
        $query  = "SELECT * ";
        $query .= "FROM site_ilan ";
        $query .= "WHERE ";
        $query .= "id='".$ilanID."' ";
        $select = $this->db->query($query);
        if($select->num_rows() > 0){
            return $select->row();
        }else{
            echo "yok";
        }
    }
    
    function editsavedenKaydet(){
        
        $category   = addslashes($this->input->post("category"));
        $description= addslashes($this->input->post("description"));
        $ilanID     = addslashes($this->input->post("ilanID"));
        $name       = addslashes($this->input->post("name"));
        $active     = addslashes($this->input->post("active"));
        $token      = addslashes($this->input->post("token"));
        $il         = $this->input->post("il");
        $ilce         = $this->input->post("ilce");
        
        //kontroller
        if(trim($category) != ""){
            if(trim($description) != ""){
                if(trim($ilanID) != ""){
                    if(trim($name) != ""){
                        if(trim($token) != ""){
                            if($token == setToken($ilanID."ilan")){
                                //kontroller tamam - kayıt başlasın
                                $query  = "UPDATE site_ilan ";
                                $query .= "SET ";
                                $query .= "category='".$category."', ";
                                $query .= "name='".$name."', ";
                                $query .= "description='".$description."', ";
                                $query .= "active='".$active."', ";
                                $query .= "il='".$il."', ";
                                $query .= "ilce='".$ilce."', ";
                                $query .= "updatedate=NOW() ";
                                $query .= "";
                                $query .= " WHERE id='".$ilanID."'";
                                $insert=$this->db->query($query);
                                echo ($this->db->affected_rows()>0) ? '{"success":"true"}' : '{"success":"false"}';
                                
                            }else{
                                //id'de çakallık yapmış
                                echo '{"success":"false"}';
                            }
                        }else{
                            //token girmedi
                            echo '{"success":"false"}';
                        }
                    }else{
                        //isim girmedi
                        echo '{"success":"false"}';
                    }
                }else{
                    //ilanid yok girmedi
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

}
?>
