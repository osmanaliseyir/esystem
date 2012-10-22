<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class modMakale extends MY_Controller {

   function __construct() {
      parent::__construct();
      Modules::run("users/users/yetkiCheck");
      $this->load->model("mod_makale_model");
   }
   
   function index() {
      $data["data"] = $this->mod_makale_model->getMakaleler();
      $this->load->view("mod/makaleler/makaleler", $data);
   }

   function add(){
       $data["categories"] = $this->mod_makale_model->getCategories();
       $this->load->view("mod/makaleler/makale_ekle",$data);
   }
   
   function save(){
       $this->template="ajax";
       $this->mod_makale_model->save();
   }
   
   
   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["categories"] = $this->mod_makale_model->getCategories();
         $data["data"]=$this->mod_makale_model->getMakale($args[0]);
         $this->load->view("mod/makaleler/makale_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->mod_makale_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {
      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->mod_makale_model->delete($args[0]);
      } else {
         show_404();
      }
   }

}
?>
