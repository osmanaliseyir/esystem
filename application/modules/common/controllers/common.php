<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class common extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("common_model");
    }

    function getIls(){
        return $this->common_model->getIls();
    }
    
    function getIlces($args){
        echo $args[0];
        return $this->common_model->getIlces($args[0]);
    }
    
    function getIlcesJson(){
        $this->template="ajax";
        $this->common_model->getIlcesJson();
    }
    
    function haberImage(){
        $this->template="ajax";
        $this->common_model->haberImage();
    }
    
    function makaleImage(){
        $this->template="ajax";
        $this->common_model->makaleImage();
    }
    
    function downloadDosyaYukle(){
        $this->template="ajax";
        $this->common_model->downloadDosyaYukle();
    }

}
?>
