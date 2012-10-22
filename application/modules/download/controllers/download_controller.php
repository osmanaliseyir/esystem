<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class download_controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("download_model");
    }

    function index($args) {
        $data["title"] = "Download - " . $this->meslekname . " | " . $this->config->item("site_title");
        $data["kategoriler"] = $this->download_model->getCategories();
        $this->load->view("category", $data);
    }

    function category($args) {
        if (isset($args[0]) && $args[0] != "") {
            $data=$this->download_model->getCategoryDownloads($args[0]);
            $this->load->view("download_view", $data);
        }
    }

    function search(){
        $data["dosyalar"]=$this->download_model->getDownloads();
        $this->load->view("arama_sonuclari",$data);
    }
    
    function file($args) {
        $this->template="";
        if (isset($args[0]) && $args[0] != "") {
            $data["id"] = $args[0];
            $this->load->view("download_file",$data);
        } else {
            show_404();
        }
    }

}

?>
