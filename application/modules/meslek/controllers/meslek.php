<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class meslek extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("meslek_model");
    }
    
    function getMesleks(){
       return $this->meslek_model->getMesleks();
    }

}
?>
