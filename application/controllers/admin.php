<?php

class Admin extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->template = "admin";
        ($this->session->userdata("user_lang")=="") ? $this->session->set_userdata("user_lang", $this->config->item("admin_language")) : "";
    }

    function index() {
        if(isset($_POST) && count($_POST)>0){
            $this->load->model("admin_main_model");
            $message=$this->admin_main_model->logincheck();
        } else {
            $message="";
        } 
        
        $this->login($message);
    }

    function login($message="") {
        $this->template = "none";

        $this->load->model("admin_main_model");
        $data["data"] = $this->admin_main_model->languages();
        $data["message"] = $message;
        $this->load->view("admin/login", $data);
    }

    function check() {
        $this->template = "ajax";
        $this->load->model("admin_main_model");
        $this->admin_main_model->check();
    }

    function dashboard() {
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";

        $this->load->model("admin_main_model");
        $this->load->view("admin/dashboard");
    }

    function logout() {
        $this->session->unset_userdata("admin_name");
        $this->session->unset_userdata("admin_id");
        $this->session->unset_userdata("admin_adsoyad");
        $this->session->unset_userdata("admin_loggedIn");
        $this->session->sess_destroy();
        redirect(base_url() . "admin");
    }

    function lang($language) {
        $this->load->model("admin_main_model");
        $this->admin_main_model->setLang($language);
        redirect(base_url() . "admin/dashboard");
    }

}

?>
