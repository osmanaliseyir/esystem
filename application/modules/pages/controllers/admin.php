<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin extends MY_Controller {

   function __construct() {
      parent::__construct();
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      $this->template = "admin";
      $this->load->model("admin_model");
   }

   function index() {
      $data["data"] = $this->admin_model->getPages();
      $this->load->view("admin/sayfalar", $data);
   }

   function add() {
      $data["langs"] = $this->admin_model->getLangs();
      $this->load->view("admin/sayfa_ekle", $data);
   }

   function save() {
      $this->template = "ajax";
      $this->admin_model->save();
   }

   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["langs"] = $this->admin_model->getLangs();
         $data["data"]=$this->admin_model->getPage($args[0]);
         $this->load->view("admin/sayfa_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->admin_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {

      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->admin_model->delete($args[0]);
      } else {
         show_404();
      }
   }

}

?>
