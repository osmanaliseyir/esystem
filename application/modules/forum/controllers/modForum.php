<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class modForum extends MY_Controller {

   function __construct() {
      parent::__construct();
      Modules::run("users/users/yetkiCheck");
      $this->load->model("mod_forum_model");
   }
   
   function index() {
      $data["meslekler"]=Modules::run("meslek/meslek/getMesleks");
      $data["data"] = $this->mod_forum_model->getItems();
      $this->load->view("mod/forum/forumlar", $data);
   }
   
   function add(){
       $data["ords"]=$this->mod_forum_model->setOrd();
       $this->load->view("mod/forum/forum_ekle",$data);
   }
   
   function save(){
       $this->template="ajax";
       $this->mod_forum_model->save();
   }
   
   function editsave($args){
       $this->template="ajax";
         if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->mod_forum_model->editsave($args[0]);
      } else {
         show_404();
      } 
   }
   
   function edit($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["meslekler"]=Modules::run("meslek/meslek/getMesleks");
         $data["data"]=$this->mod_forum_model->getItem($args[0]);
         $this->load->view("mod/forum/forum_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function delete($args) {
      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->mod_forum_model->delete($args[0]);
      } else {
         show_404();
      }
   }
   
   function deleteSelected(){
       $this->template="ajax";
       $this->mod_forum_model->deleteSelected();
   }
   
   function setOrd(){
       $this->mod_forum_model->setOrd();
   }
   /*************** ALT FORUMLAR ******************/
   function addSubForum($args=""){
       $id=$args[0];
       $data["id"]=$id;
       $data["forumlar"]=$this->mod_forum_model->getForums($id);
       $this->load->view("mod/forum/alt_forum_ekle",$data);
   }
   
  function saveSubForum(){
       $this->template="ajax";
       $this->mod_forum_model->saveSubForum();
   }
   
   function setSubOrd(){
       $this->template="ajax";
       $this->mod_forum_model->setSubOrd();
   }
  
   function editSubForum($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
        (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["data"]=$this->mod_forum_model->getSubItem($args[0]);
         $data["forumlar"]=$this->mod_forum_model->getForums($data["data"]["data"]->forum_id);
         $this->load->view("mod/forum/alt_forum_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsaveSubForum($args){
       $this->template="ajax";
         if (isset($args[0]) && $args[0] != "") {
           
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->mod_forum_model->editsaveSubForum($args[0]);
      } else {
         show_404();
      } 
   }
   
   function deleteSubForum($args) {
      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->mod_forum_model->deleteSubForum($args[0]);
      } else {
         show_404();
      }
   }
   

}
?>
