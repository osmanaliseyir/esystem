<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class mesajlarim extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("mesaj_model");
    }
    
    function index(){
        $data["data"]=$this->mesaj_model->getMessages();
        $this->load->view("mesajlarim/mesajlarim",$data);
    }

    function add(){ 
        
        $data=array();
        if(isset($_GET["reply"]) && $_GET["reply"]!="" && isset($_GET["token"])){
             if(setToken($_GET["reply"])==$_GET["token"]){
              $query = $this->db->query("SELECT * FROM site_messages WHERE id='".$_GET["reply"]."'");
              $data["data"]=$query->row();
             }
        }
         if(isset($_GET["to"]) && $_GET["to"]!=""){
              $query = $this->db->query("SELECT id as `from` FROM site_users WHERE id='".$_GET["to"]."'");
              $data["data"]=$query->row();
        }
        
        $this->load->view("mesajlarim/mesaj_ekle",$data);
    }
    
    function save(){
        $this->template="ajax";
        $this->mesaj_model->save();
    }
    
    function delete($args){
        if(isset($args[0]) && isset($_GET["token"])){
            if(setToken($args[0])==$_GET["token"]){
                $this->template="ajax";
                $this->mesaj_model->delete($args[0]);
            } else {
                show_404();
            }
         } else {
             show_404();
         }
    }
    
    function show($args){
       
        if(isset($args[0]) && isset($_GET["token"])){
            if(setToken($args[0])==$_GET["token"]){
                
                $this->db->query("UPDATE site_messages SET `read`='1' WHERE id='".$args[0]."'");
                
                $data["data"]=$this->mesaj_model->getMessage($args[0]);
                $this->load->view("mesajlarim/mesaj_goster",$data);
            } else {
                show_404();
            }
         } else {
             show_404();
         }
    }   
    
    function send(){
        $this->template="ajax";
        $this->mesaj_model->send();
    }
    function searchUser(){
        $this->template="ajax";
        $this->mesaj_model->searchUser();
    }
}
?>
