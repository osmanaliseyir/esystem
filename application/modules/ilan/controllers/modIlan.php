<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class modIlan extends MY_Controller {

    function __construct() {
        parent::__construct();
        Modules::run("users/users/yetkiCheck");
        $this->load->model("mod_ilan_model");
    }

    function index() {
        $data["title"]="İlan Yönetimi";
        $data["ilanlar"]=$this->mod_ilan_model->getIlans($this->meslekid);
        $this->load->view("mod/ilanlar",$data);
    }
    
    function ilanOnaylaReddet(){
        $this->template = "ajax";
        $this->mod_ilan_model->ilanOnaylaReddet();
    }
    
    function editsave($args){
        if (isset($args[0]) && $args[0] != "") {
            //İd Kontrolü
            (isset($_GET["token"]) && setToken($args[0]."ilan") == $_GET["token"]) ? "" : show_404();
            $data["data"] = $this->mod_ilan_model->editsave($args[0]);
            $this->load->model("ilan_model");
            $data["categories"] = $this->ilan_model->getCategoriesDropDown($this->meslekid);
            $data["iller"]=Modules::run("common/common/getIls");
            $data["ilceler"]=Modules::run("common/common/getIlces",$data["data"]->il);
            $this->load->view("mod/ilan_duzenle.php", $data);
        } else {
            show_404();
        } 
    }
    
    function editsavedenKaydet(){
        
        $this->template = "ajax";
        $this->mod_ilan_model->editsavedenKaydet();
    }
    
}
?>