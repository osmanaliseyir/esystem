<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class makaleler extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("makale_model");
    }

    function index($args) {

        $data["makaleler"] = $this->makale_model->getMakaleler();
        $data["kategoriler"] = $this->makale_model->getCategories();
        $this->load->view("makaleler", $data);
    }

    /**
     * Haber Detayı
     * @param type $id 
     */
    function detay($args) {

        $this->db->query("UPDATE site_makale SET readnum=readnum+1 WHERE id='" . $args[0] . "'");
        $data["data"] = $this->makale_model->getMakale($args[0]);
        $data["title"] = $data["data"]->name;
        $this->load->view("makale_detayi", $data);
    }

}

?>
