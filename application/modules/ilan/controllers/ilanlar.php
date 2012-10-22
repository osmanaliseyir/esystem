<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ilanlar extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("ilan_model");
    }

    function index($args) {
        //Kategoriler
        $data["title"] = "İlanlar - ".$this->meslekname. " | " . $this->config->item("site_title");
        $data["categories"] = $this->ilan_model->getCategories($this->meslekid);
        $data["categoryDropdown"] = $this->ilan_model->getCategoriesDropDown($this->meslekid);
        //İlanlar
        $data["iller"]=Modules::run("common/common/getIls");
        $data["ilanlar"] = $this->ilan_model->getIlans($this->meslekid);
        $this->load->view("ilanlar", $data);
    }

    function ekle() {
        $data["title"] = "İlan Ekle - ".$this->meslekname. " | " . $this->config->item("site_title");
        $data["categories"] = $this->ilan_model->getCategoriesDropDown($this->meslekid);
        $data["iller"]=Modules::run("common/common/getIls");
        $this->load->view("ilan_ekle", $data);
    }
    
    function ilanlarim(){
        $data["title"]="İlanlarım";
        $data["ilanlarim"]=$this->ilan_model->ilanlarim();
        $this->load->view("ilanlarim",$data);
    }
    
    function edit($args){
        
        
     if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
               
       (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $data["categories"]=$this->ilan_model->getCategoriesDropDown($args[0]);
         $data["data"]=$this->ilan_model->getIlan($args[0]);
         $data["iller"]=Modules::run("common/common/getIls");
         $data["ilceler"]=Modules::run("common/common/getIlces",$data["data"]->il);
         $this->load->view("ilan_duzenle",$data);
      } else {
         show_404();
      }  
     
   }
   
   function editsave($args){
      
       
   if (isset($args[0]) && $args[0] != "") {
       
       
        //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]."ilan") == $_GET["token"]) ? "" : show_404();
         $this->template="ajax";
         $this->ilan_model->editsave($args[0]);
      } else {
         show_404();
      }  
   }
   
   function delete($args) {
      if (isset($args[0]) && $args[0] != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && setToken($args[0]) == $_GET["token"]) ? "" : show_404();
         $this->template = "ajax";
         $this->ilan_model->delete($args[0]);
      } else {
         show_404();
      }
   }
    
    function save(){
        $this->template="ajax";
        $this->ilan_model->save();
    }
    
    function parents() {
        $this->template = "ajax";
        $this->ilan_model->parents();
    }

    /**
     * İlan Detayı
     * @param type $id 
     */
    function detay($args) {
        $data["data"] = $this->ilan_model->getIlan($args[0]);
        $data["categoryDropdown"] = $this->ilan_model->getCategoriesDropDown($this->meslekid);
        $data["title"]=$data["data"]->name. " | " . $this->config->item("site_title");
        //bu kategorideki diğer ilanlar
        $data["digerIlanlar"] = $this->ilan_model->getOtherIlans($this->meslekid, $args[0]);
        $this->db->query("UPDATE site_ilan SET readnum=readnum+1 WHERE id='" . $args[0] . "'");
        $this->load->view("ilan_detayi", $data);
    }

    function basvuru() {
        $this->template = "ajax";
        $this->ilan_model->basvuruKaydet();
    }

}

?>
