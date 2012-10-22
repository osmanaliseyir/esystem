<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getIls(){
        $data=array(""=>"Seçiniz");
        $query=$this->db->query("SELECT id,ad FROM il");
        foreach ($query->result() as $row){
            $data[$row->id]=$row->ad;
        }
        return $data;
    }
    
    function getIlces($il){
        $query=$this->db->query("SELECT id,ad FROM ilce WHERE il_id='".$il."'");
        foreach ($query->result() as $row){
            $data[$row->id]=$row->ad;
        }
        return $data;
    }

    function getIlcesJson() {
        $id = $this->input->post("id");
        $cond = " WHERE il_id='" . $id . "'";
        $query = $this->db->query("SELECT id,ad FROM ilce " . $cond . " ORDER BY ad ");
        echo '{"success":"true","data":' . json_encode($query->result()) . '}';
    }
    
    function haberImage(){
       require APPPATH.'libraries/upload.php';

      $up = new upload_photo();
      $up->uploaddir = 'public/images/haber/';
      $up->uploaded_name = 'uploadfile';
      $up->extensions = array("jpg", "png", "gif");
      $dosya_ismi = $up->single_upload_file();

      $up->image_resize_type="width";
      $up->new_width=172;
      $up->resize_image();
      
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
    
    function makaleImage(){
       require APPPATH.'libraries/upload.php';

      $up = new upload_photo();
      $up->uploaddir = 'public/images/makale/';
      $up->uploaded_name = 'uploadfile';
      $up->extensions = array("jpg", "png", "gif");
      $dosya_ismi = $up->single_upload_file();

      $up->image_resize_type="width";
      $up->new_width=172;
      $up->resize_image();
      
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
    
    //download moderatörü dosya yüklerken 
    function downloadDosyaYukle(){
        require APPPATH.'libraries/upload.php';
        $up = new upload_photo();
        $up->uploaddir = 'public/downloads/';
        $up->uploaded_name = 'uploadfile';
        //*.doc; *.docx; *.xls; *.xlsx; *.ppt; *.pptx; *.rar; *.zip; *.tif; *.psd; *.jpg; *.jpeg; *.bmp; *.gif; *.png; *.pdf
        $up->extensions = array("doc", "docx", "xls", "xlsx", "ppt", "pptx", "rar", "zip", "tif", "psd", "jpg", "jpeg", "bmp", "gif", "png", "pdf");
        $dosya_ismi = $up->single_upload_file();
        if ($dosya_ismi != "" ) {
          echo '{"success":"true", "imageurl":"'.$dosya_ismi.'", "msg":"' . lang("Dosya Başarıyla Yüklenmiştir.") . '"}';
        } else {
          echo '{"success":"false", "msg":"' . $up->result . '" }';
        }
    }

}
?>
