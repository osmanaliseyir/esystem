<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class mod_makale_Model extends CI_Model {

    public $total_rows;
    
   function __construct() {
      parent::__construct();
   }

   function save() {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $lang        = $this->input->post("lang");
      $category    = $this->input->post("category");
      $active      = $this->input->post("active");
      $image       = $this->input->post("imageurl");
      $subtitle    = addslashes($this->input->post("subtitle"));
      $query = $this->db->query("INSERT INTO site_makale VALUES ('','" . $lang . "','" . $name. "','" . $subtitle. "','".$description."',NOW(),'" . $this->session->userdata("user_id") . "','1','".$category."','" . $active . "','".$image."')");
      echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   
   /**
    * Haberleri Getirir
    * @return object
    */
   function getMakaleler() {
      
      $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND h.name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["active"]) && $_GET["active"]!=""){
            $cond.=" AND h.active='".$_GET["active"]."'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $cond.="AND h.category='".$_GET["category"]."'";
        } 
        
        $cond="WHERE c.meslek='".$this->meslekid."' ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",20";
        } else {
            $limit="LIMIT 0,20";
        }
      
       $sql  = "SELECT h.*,c.name as categoryname FROM site_makale as h LEFT JOIN site_makale_category as c ON c.id=h.category";
       $query = $this->db->query($sql." ".$cond." ORDER BY h.savedate DESC");
       $this->total_rows=$query->num_rows();
          
       $query2=$this->db->query($sql." ".$cond." ORDER BY h.savedate DESC ".$limit); 
       return $query2->result();
      
   }

   function getMakale($id) {
      $query = $this->db->query("SELECT h.*,c.name as categoryname FROM site_makale as h LEFT JOIN site_makale_category as c ON c.id=h.category WHERE h.id='".$id."' ");
      return $query->row();
   }
   
   /**
    * Haber için yüklü olan kategorileri çeker..
    * @return array data
    */
   function getCategories() {
      $data = array();
      $query = $this->db->query("SELECT id,name FROM site_makale_category WHERE meslek='".$this->meslekid."'");
      foreach ($query->result() as $row) {
         $data[$row->id] = $row->name;
      }
      return $data;
   }
   
   function editsave($id) {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $lang        = $this->input->post("lang");
      $category    = $this->input->post("category");
      $active      = $this->input->post("active");
      $subtitle    = addslashes($this->input->post("subtitle"));  
      $image       = $this->input->post("imageurl");  
      
      $query = $this->db->query("UPDATE site_makale SET 
         name='" . $name . "', 
         description='" . $description . "', 
         subtitle='".$subtitle."',
         lang='".$lang."',
         active='".$active."',
         image='".$image."',
         category='".$category."'
         WHERE id='".$id."'
         ");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   
   /**
    * Firma Silme
    * @param type $id Silinecek Menü Idsi
    */
   function delete($id) {
      $query = $this->db->query("DELETE FROM site_makale WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }

   
   /**
    * Sayfa için yüklü olan dilleri çeker..
    * @return array data
    */
   function getLangs() {
      $data = array();
      $query = $this->db->query("SELECT lang_name,lang_description FROM sys_langs ORDER by `order` ASC");
      foreach ($query->result() as $row) {
         $data[$row->lang_name] = $row->lang_description;
      }
      return $data;
   }
   
}

?>
