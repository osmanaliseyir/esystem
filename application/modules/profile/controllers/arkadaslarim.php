<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class arkadaslarim extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("arkadas_model");
    }

    function index() {
        $data["title"]="Arkadaşlarım";
        $data["istekler"]=$this->arkadas_model->getFriendRequests();
        $data["arkadaslar"]=$this->arkadas_model->getFriends();
        $this->load->view("arkadaslarim/arkadaslarim",$data);
    }
    
    function add(){
        $this->template="ajax";
        $this->arkadas_model->add();
    }
    
    function admitFriend($args){
        $this->template="ajax";
        if(isset($args[0]) && $args[0]!=""){
            $this->arkadas_model->admitFriend($args[0]);
        }
    }
    
    function ara(){
        $data["arkadaslar"]=$this->arkadas_model->getFriendsSearch();
        $this->load->view("arkadaslarim/arkadas_ara",$data);
    }

}
?>
