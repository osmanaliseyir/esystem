<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin_firma_Model extends CI_Model {
    
    public $total_rows;
    
   function __construct() {
      parent::__construct();
   }

   /**
    * Firmaları Getirir
    * @return object
    */
   function getFirmas() {
      $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["active"]) && $_GET["active"]!=""){
            $cond.=" AND active='".$_GET["active"]."'";
        }
        if(isset($_GET["vitrin"]) && $_GET["vitrin"]!=""){
            $cond.=" AND vitrin='".$_GET["vitrin"]."'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $catCond=$this->getSubCategories($_GET["category"]);
             $catCond="'".implode("','", $catCond)."'";
             $cond.="AND category IN (".$catCond.")";
        }
        $cond="WHERE 1=1 ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("firma_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("firma_rowperpage");
        }
       
       $sql="SELECT * FROM site_firma_view";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ".$limit); 
       return $query2->result();
   }

   /**
    * Düzenleme için Firmayı Getirir
    * @return object
    */
   function getFirma($id) {
      $query = $this->db->query("SELECT f.*,c.name as categoryname FROM site_firma as f LEFT JOIN site_firma_category as c ON c.id=f.category WHERE f.id='".$id."' ");
      return $query->row();
   }
   
   /**
    * Firma için yüklü olan kategorileri çeker..
    * @return array data
    */
    function getCategories($id=""){
       $cond=($id!="") ? "WHERE parent='".$id."'" : "WHERE parent='0'";
       $query = $this->db->query("SELECT id,name FROM site_firma_category ".$cond."");
       return $query->result();
    }
    
    function getCategoriesDropDown(){
        $data=array(""=>lang("Tüm Kategoriler"));
       $query = $this->db->query("SELECT id,name FROM site_firma_category WHERE parent='0'");
       foreach($query->result() as $row){
           $data[$row->id]=$row->name;
       }
       return $data;
    }
   
   function getIls() {
      $data = array();
      $query = $this->db->query("SELECT id,ad FROM il");
      foreach ($query->result() as $row) {
         $data[$row->id] = $row->ad;
      }
      return $data;
   }
   
   function getIlces($id) {
      $data = array();
      $query = $this->db->query("SELECT id,ad FROM ilce WHERE il_id='$id'");
      foreach ($query->result() as $row) {
         $data[$row->id] = $row->ad;
      }
      return $data;
   }

   function save(){
        $name = $this->input->post("name");
        $category = $this->input->post("category");
        $il = $this->input->post("il");
        $ilce = $this->input->post("ilce");
        $sabittel = $this->input->post("sabittel");
        $ceptel = $this->input->post("ceptel");
        $faks = $this->input->post("faks");
        $firmaemail = $this->input->post("firmaemail");
        $adres = $this->input->post("adres");
        $description = addslashes($this->input->post("description"));
        $adsoyad = $this->input->post("adsoyad");
        $email= $this->input->post("email");

                            if ($name != "") {
                                if ($category != "") {
                                    

                                        //Kullanıcı Kaydı
                                        $insert = $this->db->query("INSERT INTO site_users VALUES ('','2','Sistem','','',NOW(),NOW(),'1','')");
                                        $user_id = $this->db->insert_id();
                                        $update = $this->db->query("INSERT INTO site_firma VALUES ('','" . $user_id . "','" . $name . "','".$description."','" . $il . "','" . $ilce . "','','" . $category . "','" . $sabittel . "','" . $ceptel . "','" . $email . "','" . $adres . "','" . $faks . "',NOW(),NOW(),'1','" . $adsoyad . "','0')");
                                        if ($user_id > 0) {
                                            echo '{"success":"true"}';
                                        } else {
                                            echo '{"success":"false","msg":"' . lang("Hata: Kaydınız Yapılamadı!") . '"}';
                                        }
                                  
                                } else {
                                    echo '{"success":"false","msg":"' . lang("Firmanızın Kategorisini Giriniz!") . '"}';
                                }
                                
                                }else {
                                    echo '{"success":"false","msg":"' . lang("Firmanızın İsmini Giriniz!") . '"}';
                                }
   }
   
   
   function editsave($id) {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $il          = $this->input->post("il");
      $ilce        = $this->input->post("ilce");
      $logo        = $this->input->post("logo");
      $category    = $this->input->post("category");
      $sabittel    = addslashes($this->input->post("sabittel"));
      $ceptel      = addslashes($this->input->post("ceptel"));
      $email       = addslashes($this->input->post("email"));
      $adres       = addslashes($this->input->post("adres"));
      $faks        = addslashes($this->input->post("faks"));
      $active      = $this->input->post("active");
      
      $query = $this->db->query("UPDATE site_firma SET 
         name='" . $name . "', 
         description='" . $description . "', 
         il='" . $il . "', 
         ilce='" . $ilce . "', 
         logo='" . $logo . "', 
         category='" . $category . "', 
         sabittel='" . $sabittel . "', 
         ceptel='" . $ceptel . "', 
         email='" . $email . "', 
         adres='" . $adres . "', 
         faks='" . $faks . "', 
         active='" . $active . "',
         updatedate=NOW()
         WHERE id='".$id."'
         ");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   
   function getSubCategories($id=""){
        $id= ($id!="") ? $id : 0;
        $data[]=$id;
       $query= $this->db->query("SELECT id FROM site_firma_category WHERE parent='$id'");
        foreach ($query->result() as $row) {
            $data[]=$row->id;
             $query2= $this->db->query("SELECT id FROM site_firma_category WHERE parent='$id'");
            if($query2->num_rows()>0){
                $this->getSubCategories($row->id);
            }
        }
        return $data;
    }
   
   /**
    * Firma Silme
    * @param type $id Silinecek Menü Idsi
    */
   function delete($id) {
      $query = $this->db->query("DELETE FROM site_firma WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }

   function active(){
       $affected=0;
     if (is_array($this->input->post("sec")) && count($this->input->post("sec"))>0){
         foreach ($this->input->post("sec") as $s){
             $query = $this->db->query("UPDATE site_firma SET active='1' WHERE id='".$s."'");
             ($this->db->affected_rows()>0)? $affected++  : "";
         }
         echo '{"success":"true","affected":"'.$affected.'"}';
     } else {
         echo '{"success":"false","msg":"'.lang("Öncelikle Seçim Yapmalısınız").'"}';
     }
   }
   
   function pasive(){
       $affected=0;
     if (is_array($this->input->post("sec")) && count($this->input->post("sec"))>0){
         foreach ($this->input->post("sec") as $s){
             $query = $this->db->query("UPDATE site_firma SET active='0' WHERE id='".$s."'");
             ($this->db->affected_rows()>0)? $affected++  : "";
         }
         echo '{"success":"true","affected":"'.$affected.'"}';
     } else {
         echo '{"success":"false","msg":"'.lang("Öncelikle Seçim Yapmalısınız").'"}';
     }
   }
   
   function deleteSelected(){
       $affected=0;
     if (is_array($this->input->post("sec")) && count($this->input->post("sec"))>0){
         foreach ($this->input->post("sec") as $s){
             $query = $this->db->query("DELETE FROM site_firma WHERE id='".$s."'");
             ($this->db->affected_rows()>0)? $affected++  : "";
         }
         echo '{"success":"true","affected":"'.$affected.'"}';
     } else {
         echo '{"success":"false","msg":"'.lang("Öncelikle Seçim Yapmalısınız").'"}';
     }
   }
   
   function gozde(){
       $affected=0;
     if (is_array($this->input->post("sec")) && count($this->input->post("sec"))>0){
         foreach ($this->input->post("sec") as $s){
             $query = $this->db->query("UPDATE site_firma SET vitrin='1' WHERE id='".$s."'");
             ($this->db->affected_rows()>0)? $affected++  : "";
         }
         echo '{"success":"true","affected":"'.$affected.'"}';
     } else {
         echo '{"success":"false","msg":"'.lang("Öncelikle Seçim Yapmalısınız").'"}';
     }
   }
   
   function normal(){
       $affected=0;
     if (is_array($this->input->post("sec")) && count($this->input->post("sec"))>0){
         foreach ($this->input->post("sec") as $s){
             $query = $this->db->query("UPDATE site_firma SET vitrin='0' WHERE id='".$s."'");
             ($this->db->affected_rows()>0)? $affected++  : "";
         }
         echo '{"success":"true","affected":"'.$affected.'"}';
     } else {
         echo '{"success":"false","msg":"'.lang("Öncelikle Seçim Yapmalısınız").'"}';
     }
   }
   
   
}

?>
