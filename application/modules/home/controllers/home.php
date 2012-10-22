<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("home_model");
    }

    function index() {
        $user_id = $this->session->userdata("user_id");
        ($user_id != "") ? redirect(base_url() . "profilim") : "";
        $this->home_model->cookieCheck();
        
        $this->load->view("home");
    }

    function signup() {
        $data["title"]="Üye Ol";
        $data["meslekler"] = Modules::run("meslek/meslek/getMesleks");
        $this->load->view("signup", $data);
    }
    
    function login() {
        $data["error"] = $this->home_model->user_login();
        $this->load->view("login", $data);
    }

    //Kullanıcı Kayıt
    function useradd() {
        $this->template = "ajax";
        $this->home_model->user_add();
    }

    function sifremiunuttum() {
        $data["title"] = "Şifremi Unuttum";
        $this->load->view("sifremi_unuttum", $data);
    }

    function userforgotpassword() {
        $this->template = "ajax";
        $this->home_model->user_forgotpassword();
    }

    function flogin() {
        $this->template = "none";
        $this->load->view("facebook");
    }

    function floginget() {
        $this->template = "empty";
        $this->home_model->floginget();
    }

    function meslekler(){
        $data["meslekler"]=$this->home_model->getMesleks();
        $this->load->view("meslekler",$data);
    }
    
    function page($args) {

        if (file_exists("application/modules/home/views/pages/" . $args[0] . ".php")) {
            require "application/modules/home/views/pages/" . $args[0] . ".php";
        } else {
            show_404();
        }
    }

}

?>