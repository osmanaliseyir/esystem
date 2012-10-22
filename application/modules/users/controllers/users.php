<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class users extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("user_model");
    }

    function index() {
        
    }
    
    function detay($args){
        if(isset($args[0]) && $args[0]!=""){
            $data=$this->user_model->getUser($args[0]);
            $data["title"]=$data["user"]->adsoyad;
            $this->load->view("kullanici",$data);
        } else {
            show_404();
        }
    }
    
    //Kullanıcı moderatör ise hangi modüllere yetkisi var
    function yetkiCheck(){
        $ibrahim = $this->user_model->yetkiCheck();
        
    }
   
    
    

}

?>
