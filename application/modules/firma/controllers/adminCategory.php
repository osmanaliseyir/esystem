<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class adminCategory extends MY_Controller {

   function __construct() {
      parent::__construct();
      ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      $this->template = "admin";
      $this->load->model("admin_category_model");
   }
   
   function index() {
      $data["data"] = $this->admin_category_model->getCategories();
      $this->load->view("admin/kategori/kategoriler", $data);
   }
  
   function parents(){
      $this->template="ajax";
      $this->admin_category_model->parents();
   }
   
   function add() {
      $this->load->view("admin/kategori/kategori_ekle");
   }

   function save() {
      $this->template = "ajax";
      $this->admin_category_model->save();
   }

   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["data"]=$this->admin_category_model->getCategory($args[0]);
         $this->load->view("admin/kategori/kategori_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->admin_category_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {

      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->admin_category_model->delete($args[0]);
      } else {
         show_404();
      }
   }

}

?>
