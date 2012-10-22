<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class adminHaber extends MY_Controller {

   function __construct() {
      parent::__construct();
      $this->template = "admin";
      $this->load->model("admin_haber_model");
   }
   
   function index() {
       ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      $data["data"] = $this->admin_haber_model->getHaberler();
      $this->load->view("admin/haber/haberler", $data);
   }

   function add(){
       ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
       $data["langs"] = $this->admin_haber_model->getLangs();
       $this->load->view("admin/haber/haber_ekle",$data);
   }
   
   function addImage(){
       $this->template="ajax";
       $this->admin_haber_model->addImage();
   }
   
   function save(){
       ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
       $this->template="ajax";
       $this->admin_haber_model->save();
   }
   
   
   function edit($args){
       ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["categories"] = $this->admin_haber_model->getCategories();
         $data["data"]=$this->admin_haber_model->getHaber($args[0]);
         $this->load->view("admin/haber/haber_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->admin_haber_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->admin_haber_model->delete($args[0]);
      } else {
         show_404();
      }
   }

}
?>
