<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class firmalar extends MY_Controller {

    function __construct() {
        parent::__construct();
         $this->load->model("firma_model");
    }
    
    function index(){
        //Kategoriler
        $data["categories"]=$this->firma_model->getCategories();
        $data["categoryDropdown"]=$this->firma_model->getCategoriesDropDown();
        
        //Firmalar
        $data["firmalar"]=$this->firma_model->getFirmas();
        
        $this->load->view("firmalar",$data);
        
    }
    
    function detayliarama(){
         //Kategoriler
        $data["categories"]=$this->firma_model->getCategories();
        $data["categoryDropdown"]=$this->firma_model->getCategoriesDropDown();
        
        //Firmalar
        $data["firmalar"]=$this->firma_model->getFirmas();
        
        $this->load->view("firmalar",$data);
    }
    
    
    function parents(){
        $this->template="ajax";
        $this->firma_model->parents();
    }
    
    /**
     * Firma Detayı
     * @param type $id 
     */
    function detay($args){
        $data["data"]=$this->firma_model->getFirma($args[0]);
        $data["photos"]=$this->firma_model->getPhotos();
        $data["firmailanlari"]=$this->firma_model->getFirmaIlans($args[0]);
        $this->load->view("firma_detayi",$data);
    }

}
?>
