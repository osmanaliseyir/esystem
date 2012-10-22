<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin extends MY_Controller {

    function __construct() {
      parent::__construct();
      ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      $this->load->model("admin_model");
      $this->template = "admin";
    }

    function index() {
        $this->load->view("admin/ayarlar");
    }

    /**
     * Site Ayarları
     */

    function site() {
        $data["data"]=$this->admin_model->config();
        $data["languages"]=$this->admin_model->languages();
        $this->load->view("admin/site_ayarlari",$data);
    }

    /**
     * Yönetim Ayarları
     */

    function yonetim() {
        $data["data"]=$this->admin_model->config("admin");
        $data["languages"]=$this->admin_model->languages();
        $this->load->view("admin/yonetim_ayarlari",$data);
    }

    /**
     * Kullanıcı Ayarları
     */

    function user() {
        $data["data"]=$this->admin_model->config("user");
        $this->load->view("admin/kullanici_ayarlari",$data);
    }

    /**
     * İletişim Ayarları
     */

    function contact() {
        $data["data"]=$this->admin_model->config("contact");
        $this->load->view("admin/iletisim_ayarlari",$data);
    }
    
    /**
     * Firma Ayarları
     */

    function firma() {
        $data["data"]=$this->admin_model->config("firma");
        $this->load->view("admin/firma_ayarlari",$data);
    }
    
    /**
     * Haber Ayarları
     */

    function haber() {
        $data["data"]=$this->admin_model->config("haber");
        $this->load->view("admin/haber_ayarlari",$data);
    }
    
    /**
     * İlan Ayarları
     */

    function ilan() {
        $data["data"]=$this->admin_model->config("ilan");
        $this->load->view("admin/ilan_ayarlari",$data);
    }
    
    /**
     * Ayarları Kaydet
     */
    function save(){
       $this->template="ajax";
       $this->admin_model->save();
    }

}
?>
