<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin_haber_Model extends CI_Model {

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
      $query = $this->db->query("INSERT INTO site_haber VALUES ('','" . $lang . "','" . $name. "','" . $subtitle. "','".$description."',NOW(),'" . $this->session->userdata("user_id") . "','1','".$category."','" . $active . "','".$image."')");
      echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
   
   
   /**
    * Haberleri Getirir
    * @return object
    */
   function getHaberler() {
      $query = $this->db->query("SELECT h.*,c.name as categoryname FROM site_haber as h LEFT JOIN site_haber_category as c ON c.id=h.category");
      return $query->result();
   }

   /**
    * Düzenleme için Firmayı Getirir
    * @return object
    */
   function getHaber($id) {
      $query = $this->db->query("SELECT h.*,c.name as categoryname FROM site_haber as h LEFT JOIN site_haber_category as c ON c.id=h.category WHERE h.id='".$id."' ");
      return $query->row();
   }
   
   /**
    * Haber için yüklü olan kategorileri çeker..
    * @return array data
    */
   function getCategories() {
      $data = array();
      $query = $this->db->query("SELECT id,name FROM site_haber_category");
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
      
      $query = $this->db->query("UPDATE site_haber SET 
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
      $query = $this->db->query("DELETE FROM site_haber WHERE id='$id'");
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
   
   function addImage(){
       require APPPATH.'libraries/upload.php';

      $up = new upload_photo();
      $up->uploaddir = 'public/images/haber/';
      $up->uploaded_name = 'uploadfile';
      $up->extensions = array("jpg", "png", "gif");
      $dosya_ismi = $up->single_upload_file();

      $up->thumb_save_dir = $up->uploaddir . "thumb/";
      $up->CroppedThumbnail(100, 75);
      
      $up->thumb_save_dir = $up->uploaddir . "thumb1/";
      $up->CroppedThumbnail(150, 110);
      
      $up->thumb_save_dir = $up->uploaddir . "thumb2/";
      $up->CroppedThumbnail(300, 240);
      
      if ($dosya_ismi != "" ) {
         echo '{"success":"true", "imageurl":"'.$dosya_ismi.'", "msg":"' . lang("Resim Başarıyla Yüklenmiştir.") . '"}';
      } else {
         echo '{"success":"false", "msg":"' . $up->result . '" }';
      }
   }
   
}

?>
