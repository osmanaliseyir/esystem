<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class haberler extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("haber_model");
    }

    function index($args) {

        if (isset($args[0]) && $args[0] != "") {
            $query = $this->db->query("SELECT id,name FROM site_meslek WHERE urlname='" . $args[0] . "'");
            $row = $query->row();
            if ($query->num_rows() > 0) {
                //Haberler
                $data["haberler"] = $this->haber_model->getHaberler();
                $this->load->view("haberler", $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    function detayliarama() {
        //Kategoriler
        $data["categories"] = $this->haber_model->getCategories();
        $data["categoryDropdown"] = $this->haber_model->getCategoriesDropDown();

        //Haberler
        $data["haberler"] = $this->haber_model->getHaberler();

        $this->load->view("haberler", $data);
    }

    function parents() {
        $this->template = "ajax";
        $this->haber_model->parents();
    }

    /**
     * Haber Detayı
     * @param type $id 
     */
    function detay($args) {

        $this->db->query("UPDATE site_haber SET readnum=readnum+1 WHERE id='" . $args[0] . "'");

        $data["data"] = $this->haber_model->getHaber($args[0]);
        $data["title"] = $data["data"]->name;
        $this->load->view("haber_detayi", $data);
    }

}

?>
