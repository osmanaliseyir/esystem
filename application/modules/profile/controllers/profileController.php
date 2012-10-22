<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class profileController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $user_id=$this->session->userdata("user_id");
        (isset($user_id) && $user_id!="" && intval($user_id)>0) ? "" : redirect(base_url());
        $this->load->model("profile_model");
    }

    function index() {
        $data["title"]="Profilim";
        $data["meslekler"]=Modules::run("meslek/meslek/getMesleks");
        $this->load->view("profilim",$data);
    }
   
    /**
     * 
     * Şifre Değiştirme..
     */
    
    function changepassword(){
        $data["title"]="Şifre Değiştirme";
        $this->load->view("sifre_degistir",$data);
    }
    
    function changepasswordCheck(){
        $this->template="ajax";
        $this->profile_model->changepasswordCheck();
    }
    
    /**
     * Bilgilerimi Düzenle
     */
    function duzenle(){
        $data["title"]="Bilgilerimi Düzenle";
        $data["meslekler"]=Modules::run("meslek/meslek/getMesleks");
        $data["data"]=$this->profile_model->getMyInformation();
        $this->load->view("bilgilerimi_duzenle",$data);   
    }
    
    function kaydet(){
        $this->template="ajax";
        $this->profile_model->saveMyInformation();
    }
    
    function changephoto(){
        $data["title"]="Fotoğraf Değiştir";
        $this->load->view("fotograf",$data);
    }
    
    function friends(){
        $data["title"]="Arkadaşlarım";
        $this->load->view("arkadaslarim");
    }
    
    
    function user_logout(){
        $this->profile_model->user_logout();
    }

}
?>
