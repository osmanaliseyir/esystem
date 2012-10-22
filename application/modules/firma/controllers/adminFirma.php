<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class adminFirma extends MY_Controller {

   function __construct() {
      parent::__construct();
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      $this->template = "admin";
      $this->load->model("admin_firma_model");
   }
   
  function index() {
      //Kategoriler
        $data["categories"]=$this->admin_firma_model->getCategories();
        $data["categoryDropdown"]=$this->admin_firma_model->getCategoriesDropDown();
        
        //İlanlar
        $data["firmalar"]=$this->admin_firma_model->getFirmas();
        
        $this->load->view("admin/firma/firmalar",$data);
   }
   
   function detayliarama(){
         //Kategoriler
        $data["categories"]=$this->admin_firma_model->getCategories();
        $data["categoryDropdown"]=$this->admin_firma_model->getCategoriesDropDown();
        
        //İlanlar
        $data["firmalar"]=$this->admin_firma_model->getFirmas();
        
        $this->load->view("admin/firma/firmalar",$data);
    }

    function add(){
        $data["categories"] = $this->admin_firma_model->getCategories();
         $data["ils"] = $this->admin_firma_model->getIls();
         $data["ilces"] = $this->admin_firma_model->getIlces(1);
        $this->load->view("admin/firma/firma_ekle",$data);
    }
    
    
    function save(){
        $this->template="ajax";
        $this->admin_firma_model->save();
    }
    
   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["categories"] = $this->admin_firma_model->getCategories();
         $data["ils"] = $this->admin_firma_model->getIls();
         $data["data"]=$this->admin_firma_model->getFirma($args[0]);
         $data["ilces"] = $this->admin_firma_model->getIlces($data["data"]->il);
         $this->load->view("admin/firma/firma_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->admin_firma_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {

      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->admin_firma_model->delete($args[0]);
      } else {
         show_404();
      }
   }
   
   function active(){
       $this->template="ajax";
       $this->admin_firma_model->active();
   }
   
   function pasive(){
       $this->template="ajax";
       $this->admin_firma_model->pasive();
   }
   
   function deleteSelected(){
       $this->template="ajax";
       $this->admin_firma_model->deleteSelected();
   }
   
   function gozde(){
       $this->template="ajax";
       $this->admin_firma_model->gozde();
   }
   
   function normal(){
       $this->template="ajax";
       $this->admin_firma_model->normal();
   }

}
?>
