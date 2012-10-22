<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class adminIlan extends MY_Controller {

   function __construct() {
      parent::__construct();
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
      $this->template = "admin";
      $this->load->model("admin_ilan_model");
   }
   
   function index() {
      //Kategoriler
        $data["categories"]=$this->admin_ilan_model->getCategories();
        $data["categoryDropdown"]=$this->admin_ilan_model->getCategoriesDropDown();
        
        //İlanlar
        $data["ilanlar"]=$this->admin_ilan_model->getIlans();
        
        $this->load->view("admin/ilan/ilanlar",$data);
   }
   
   function detayliarama(){
         //Kategoriler
        $data["categories"]=$this->admin_ilan_model->getCategories();
        $data["categoryDropdown"]=$this->admin_ilan_model->getCategoriesDropDown();
        
        //İlanlar
        $data["ilanlar"]=$this->admin_ilan_model->getIlans();
        
        $this->load->view("admin/ilan/ilanlar",$data);
    }
    

   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["categories"] = $this->admin_ilan_model->getCategories();
         $data["ils"] = $this->admin_ilan_model->getIls();
         $data["data"]=$this->admin_ilan_model->getIlan($args[0]);
         $data["ilces"] = $this->admin_ilan_model->getIlces($data["data"]->il);
         $this->load->view("admin/ilan/ilan_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsave($args){
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->admin_ilan_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {

      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->admin_ilan_model->delete($args[0]);
      } else {
         show_404();
      }
   }
   
   function active(){
       $this->template="ajax";
       $this->admin_ilan_model->active();
   }
   
   function pasive(){
       $this->template="ajax";
       $this->admin_ilan_model->pasive();
   }
   
   function deleteSelected(){
       $this->template="ajax";
       $this->admin_ilan_model->deleteSelected();
   }
   

}
?>
