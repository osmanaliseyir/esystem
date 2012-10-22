<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class download_mod_controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("download_mod_model");
    }

    function index($args) {
        $data["title"] = "Download Yönetim - ".$this->meslekname;
        $data["downloads"] = $this->download_mod_model->getDownloads($this->meslekid);
        $data["dosyaCategoryDropdown"] = $this->download_mod_model->dosyaCategoryDropdown($this->meslekid);
        $this->load->view("mod/download_mod_view", $data);
    }
    
    function yukle($args){
        if(isset($args[0]) && isset($args[1])){
            if(setToken($args[0]."download")==$args[1]){
                $data["downloadValues"] = $this->download_mod_model->downloadValues($args[0]);
            }
        }
        $data["title"] = "Dosya Yükle";
        $data["dosyaCategoryDropdown"] = $this->download_mod_model->dosyaCategoryDropdown($this->meslekid);
        $this->load->view("mod/yukle_mod_view", $data);
    }
    
    function yukle_save(){
        $this->template = "ajax";
        $this->download_mod_model->yukle_save();
    }
    
}

?>