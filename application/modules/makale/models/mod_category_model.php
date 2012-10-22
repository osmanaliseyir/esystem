<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class mod_category_Model extends CI_Model {

   function __construct() {
      parent::__construct();
   }

   /**
    * Kategorileri Getirir
    * @return object
    */
   function getCategories() {
      $query = $this->db->query("SELECT * FROM site_makale_category WHERE meslek='".$this->meslekid."'");
      return $query->result();
   }

   /**
    * Düzenleme için Kategoriyi Getirir
    * @return object
    */
   function getCategory($id) {
      $query = $this->db->query("SELECT * FROM site_makale_category WHERE meslek='".$this->meslekid."' and id='".$id."' ");
      return $query->row();
   }

   /**
    * Kaydet
    */
   function save() {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $ord         = $this->input->post("ord");

      $query = $this->db->query("INSERT INTO site_makale_category VALUES ('','" . $name . "','" . $description . "','" . $this->meslekid . "','" . $ord . "')");
      echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   function editsave($id) {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $ord         = $this->input->post("ord");

      $query = $this->db->query("UPDATE site_makale_category SET name='" . $name . "', description='" . $description . "', ord='" . $ord . "' WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   /**
    *  Silme
    * @param type $id Silinecek Idi
    */
   function delete($id) {
      $query = $this->db->query("DELETE FROM site_makale_category WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   function parents(){
      $data=$this->submenus(0);
      echo '{"data":['.$data.']}';
   }
   
   function subMenus($parent) {
      $result="";
      $i=0;
      $query = $this->db->query("SELECT * FROM site_meslek");
      foreach($query->result() as $row){
         $i++;
         
            $result.='{';
            $result.='"cls":"file",';
            $result.='"name":"'.$row->name.'",';
            $result.='"id":"'.$row->id.'"';
            $result.='}';
         
         $result.=($i==$query->num_rows()) ? "" :",";
      }
      return $result;
   }

}

?>
