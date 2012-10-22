<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class modHaber extends MY_Controller {

   function __construct() {
      parent::__construct();
      Modules::run("users/users/yetkiCheck");
      $this->load->model("mod_haber_model");
   }
   
   function index() {
      $data["data"] = $this->mod_haber_model->getHaberler();
      $this->load->view("mod/haber/haberler", $data);
   }

   function add(){
       $data["categories"] = $this->mod_haber_model->getCategories();
       $this->load->view("mod/haber/haber_ekle",$data);
   }
   
   function save(){
       $this->template="ajax";
       $this->mod_haber_model->save();
   }
   
   
   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["categories"] = $this->mod_haber_model->getCategories();
         $data["data"]=$this->mod_haber_model->getHaber($args[0]);
         $this->load->view("mod/haber/haber_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->mod_haber_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {
      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->mod_haber_model->delete($args[0]);
      } else {
         show_404();
      }
   }

}
?>
