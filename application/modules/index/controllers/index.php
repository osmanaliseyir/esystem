<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class index extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index($args) {
        $query = $this->db->query("SELECT id,name FROM site_meslek WHERE urlname='".$args[0]."'");
        $row=$query->row();
        if($query->num_rows()>0){
            $data["title"]="E-Meslek - ".$row->name;
            $this->meslekid=$row->id;
            $this->meslekname=$row->name;
            $this->load->view("index",$data);
        } else {
            show_404();
        }
    }

}
?>
