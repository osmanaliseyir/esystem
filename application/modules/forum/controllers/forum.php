<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class forum extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("forum_model");
    }

    function index($args="") {
        if (isset($args[0]) && $args[0] != "") {
            $meslekname=$this->forum_model->returnName($args[0]);
            $data["mesleks"] = array("url"=>$args[0],"name"=>$meslekname);
            $data["data"] = $this->forum_model->getForums($args[0]);
            $data["title"] = $meslekname." Forumu";
            $this->load->view("forumlar", $data);
        } else {
            show_404();
        }
    }

    function subForums($args) {
        if (isset($args[0]) && $args[0] != "") {
            $data["data"] = $this->forum_model->getTopics($args[0]);
            $data["title"] =$data["data"]["meslek"]["name"]." Forumu - ".$data["data"]["altforum"]["name"];
            $this->load->view("konular", $data);
        } else {
            show_404();
        }
    }
    
    function addTopic($id){
    	$data["title"]="Konu Ekle";
    	$data["id"]=$id[0];
    	$this->load->view("konu_ekle",$data);
    }
    
    function saveTopic($args){
    	$this->template="ajax";
    	if (isset($args[0]) && $args[0] != "") {
    		$this->forum_model->saveTopic($args[0]);
    	} else {
            show_404();
        }
    }
    
    function editTopic($args){
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["data"]=$this->forum_model->getTopic($args[0]);
         $data["id"]=$args[0];
         $this->load->view("konu_duzenle",$data);
      } else {
         show_404();
      } 
   }
   
   function editsaveTopic($args){
       $this->template="ajax";
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["data"]=$this->forum_model->editsaveTopic($args[0]);
      } else {
         show_404();
      } 
   }
    
   function deleteTopic($args){
       $this->template="ajax";
       if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->forum_model->deleteTopic($args[0]);
      } else {
         show_404();
      } 
   }
    
    function saveReply($args){
    	$this->template="ajax";
    	if (isset($args[0]) && $args[0] != "") {
    		$this->forum_model->saveReply($args[0]);
    	} else {
            show_404();
        }
    }
    
    
    function showTopic($args){
         if (isset($args[0]) && $args[0] != "") {
            $data["data"]=$this->forum_model->showTopic($args[0]);
            $data["title"]=$data["data"]["konu"]->name;
            $this->load->view("konu_detayi",$data);
        } else {
            show_404();
        }        
    }
    
    function myTopics(){
        $data["konular"]=$this->forum_model->myTopics();
        $data["title"]="Forum Konularım";
        $this->load->view("konularim",$data);
        
    }

}

?>
