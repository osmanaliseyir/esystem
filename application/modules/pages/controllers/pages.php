<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class pages extends MY_Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index($args){
        $query= $this->db->query("SELECT * FROM sys_pages WHERE urlname='".$args[0]."' ");
        if($query->num_rows()>0){
            $data["data"]=$query->row();
            $this->load->view("sayfa",$data);
        } else {
            show_404();
        }
    }

}
?>
