<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class mod extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        
        //Mod veya admin mi?
        $meslek = $this->uri->segment(1);
        $query = $this->db->query("SELECT id FROM site_meslek WHERE urlname='" . $meslek . "'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $meslek_id = $row->id;

            //Admin İse
            $query1 = $this->db->query("SELECT id FROM site_yetkilendirme WHERE user_id='" . $this->session->userdata("user_id") . "' AND meslek_id='" . $meslek_id . "' AND (type='1' OR type='2')");
            if ($query1->num_rows() > 0) {
                //Devam
            }
        } else {
           show_404();
        }
        
        $data["title"]=$this->meslekname." Mesleği Yönetimi";
        $this->load->view("mod",$data);
    }

}
?>
