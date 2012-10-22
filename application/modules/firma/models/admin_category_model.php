<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin_category_Model extends CI_Model {

   function __construct() {
      parent::__construct();
   }

   /**
    * Kategorileri Getirir
    * @return object
    */
   function getCategories() {
      $query = $this->db->query("SELECT c.*, p.name as parentname FROM site_firma_category as c LEFT JOIN site_firma_category as p ON c.parent=p.id");
      return $query->result();
   }

   /**
    * Düzenleme için Kategoriyi Getirir
    * @return object
    */
   function getCategory($id) {
      $query = $this->db->query("SELECT c.*, p.name as parentname FROM site_firma_category as c LEFT JOIN site_ilan_category as p ON c.parent=p.id WHERE c.id='".$id."' ");
      return $query->row();
   }

   /**
    * Kaydet
    */
   function save() {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $parent      = $this->input->post("parent");
      $ord         = $this->input->post("icon");

      $query = $this->db->query("INSERT INTO site_firma_category VALUES ('','" . $name . "','" . $description . "','" . $parent . "','" . $ord . "','".  url_title($name,'dash',true)."')");
      echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   function editsave($id) {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $parent      = $this->input->post("parent");
      $ord         = $this->input->post("icon");

      $query = $this->db->query("UPDATE site_firma_category SET name='" . $name . "', description='" . $description . "', parent='" . $parent . "', ord='" . $ord . "', url='".url_title($name,'dash',true)."' WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   /**
    *  Silme
    * @param type $id Silinecek Idi
    */
   function delete($id) {
      $query = $this->db->query("DELETE FROM site_firma_category WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   function parents(){
      $data=$this->submenus(0);
      echo '{"data":['.$data.']}';
   }
   
   function subMenus($parent) {
      $result="";
      $i=0;
      $query = $this->db->query("SELECT * FROM site_firma_category WHERE parent='$parent'");
      foreach($query->result() as $row){
         $i++;
         $query2 = $this->db->query("SELECT id,name FROM  site_firma_category WHERE parent='" . $row->id . "'");
         if($query2->num_rows()>0){
            $result.='{';
            $result.='"cls":"folder",';
            $result.='"name":"'.$row->name.'",';
            $result.='"id":"'.$row->id.'"';
            $result.=',"menu":['.$this->subMenus($row->id).']';
            $result.='}';
         } else {
            $result.='{';
            $result.='"cls":"file",';
            $result.='"name":"'.$row->name.'",';
            $result.='"id":"'.$row->id.'"';
            $result.='}';
         }
         $result.=($i==$query->num_rows()) ? "" :",";
      }
      return $result;
   }

}

?>
