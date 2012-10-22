<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin_ilan_Model extends CI_Model {

    public $totalrows;
    
   function __construct() {
      parent::__construct();
     
   }

   function getCategories($id=""){
       $cond=($id!="") ? "WHERE meslek='".$id."'" : "WHERE meslek='0'";
       $query = $this->db->query("SELECT id,name FROM site_ilan_category ".$cond."");
       return $query->result();
    }
    
    function getCategoriesDropDown(){
        $data=array(""=>lang("Tüm Kategoriler"));
       $query = $this->db->query("SELECT id,name FROM site_ilan_category WHERE meslek='0'");
       foreach($query->result() as $row){
           $data[$row->id]=$row->name;
       }
       return $data;
    }
    
    function getIlans($cond=""){
       $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND site_ilan_view.name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["type"]) && $_GET["type"]!=""){
            $cond.=" AND user_type='".$_GET["type"]."'";
        }
        if(isset($_GET["active"]) && $_GET["active"]!=""){
            $cond.=" AND site_ilan_view.active='".$_GET["active"]."'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $catCond=$this->getSubCategories($_GET["category"]);
             $catCond="'".implode("','", $catCond)."'";
             $cond.="AND site_ilan_view.category IN (".$catCond.")";
        }
        $cond="WHERE 1=1 ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("ilan_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("ilan_rowperpage");
        }
              $sql="SELECT site_ilan_view.*,site_firma.name as firmaad,site_firma.id as firmaid FROM site_ilan_view LEFT JOIN site_firma ON site_ilan_view.uf_id=site_firma.user_id";

        
       $query = $this->db->query($sql." ".$cond." ORDER BY savedate DESC ");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit); 
       return $query2->result();
    }

   /**
    * Düzenleme için Firmayı Getirir
    * @return object
    */
   function getIlan($id) {
      $query = $this->db->query("SELECT i.*,c.name as categoryname FROM site_ilan as i LEFT JOIN site_ilan_category as c ON c.id=i.category WHERE i.id='".$id."' ");
      return $query->row();
   }
   
   /**
    * İlan için yüklü olan kategorileri çeker..
    * @return array data
    */
  
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

   function editsave($id) {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $il          = $this->input->post("il");
      $ilce        = $this->input->post("ilce");
      $category    = $this->input->post("category");
      $active      = $this->input->post("active");
      
      $select=$this->db->query("SELECT user_type FROM site_ilan WHERE id='$id'");
      $row=$select->row();
      
      if($row->user_type=="2"){
         $yas         = $this->input->post("yas");
         $cinsiyet    = $this->input->post("cinsiyet"); 
         $condition=    " yas='".$yas."', cinsiyet='".$cinsiyet."', ";
      } else {
          $condition="";
      }
      
      $query = $this->db->query("UPDATE site_ilan SET 
         name='" . $name . "', 
         description='" . $description . "', 
         il='" . $il . "', 
         ilce='" . $ilce . "',
         ".$condition."
         active='" . $active . "',
         updatedate=NOW()
         WHERE id='".$id."'
         ");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   function getSubCategories($id=""){
        $id= ($id!="") ? $id : 0;
        $data[]=$id;
       $query= $this->db->query("SELECT id FROM site_ilan_category WHERE parent='$id'");
        foreach ($query->result() as $row) {
            $data[]=$row->id;
             $query2= $this->db->query("SELECT id FROM site_ilan_category WHERE parent='$id'");
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
      $query = $this->db->query("DELETE FROM site_ilan WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }

   function active(){
       $affected=0;
     if (is_array($this->input->post("sec")) && count($this->input->post("sec"))>0){
         foreach ($this->input->post("sec") as $s){
             $query = $this->db->query("UPDATE site_ilan SET active='1' WHERE id='".$s."'");
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
             $query = $this->db->query("UPDATE site_ilan SET active='0' WHERE id='".$s."'");
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
             $query = $this->db->query("DELETE FROM site_ilan WHERE id='".$s."'");
             ($this->db->affected_rows()>0)? $affected++  : "";
         }
         echo '{"success":"true","affected":"'.$affected.'"}';
     } else {
         echo '{"success":"false","msg":"'.lang("Öncelikle Seçim Yapmalısınız").'"}';
     }
   }
   
   
}

?>
