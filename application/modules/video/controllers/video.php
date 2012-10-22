<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class video extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view("video");
    }

}
?>
