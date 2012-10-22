<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin_Model extends CI_Model {

   function __construct() {
      parent::__construct();
   }

   /**
    * Sayfaları Getirir
    * @return object
    */
   function getPages() {
      $query = $this->db->query("SELECT sys_pages.*,sys_langs.lang_description as language FROM sys_pages INNER JOIN sys_langs ON sys_langs.lang_name=sys_pages.lang ");
      return $query->result();
   }

   /**
    * Düzenleme için Sayfayı Getirir
    * @return object
    */
   function getPage($id) {
      $query = $this->db->query("SELECT * FROM sys_pages WHERE id='".$id."' ");
      return $query->row();
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

   /**
    * Kaydet
    */
   function save() {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $type        = $this->input->post("type");
      $lang        = $this->input->post("lang");
      $active      = $this->input->post("active");
      $urlname     = $this->input->post("urlname");

      $query = $this->db->query("INSERT INTO sys_pages VALUES ('','" . $name . "','" . $description . "','" . $lang . "',NOW(),NOW(),'" . $type . "','" . $active . "','".$urlname."')");
      echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   function editsave($id) {
      $name        = addslashes($this->input->post("name"));
      $description = addslashes($this->input->post("description"));
      $type        = $this->input->post("type");
      $lang        = $this->input->post("lang");
      $active      = $this->input->post("active");
      $urlname     = $this->input->post("urlname");

      $query = $this->db->query("UPDATE sys_pages SET name='" . $name . "', description='" . $description . "', lang='" . $lang . "', urlname='" . $urlname . "', updatedate=NOW(), type='" . $type . "', active='" . $active . "' WHERE id='".$id."'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   
   /**
    * Sayfa Silme
    * @param type $id Silinecek Menü Idsi
    */
   function delete($id) {
      $query = $this->db->query("DELETE FROM sys_pages WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }

}

?>
