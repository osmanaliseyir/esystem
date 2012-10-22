<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class user_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getUser($id) {
        $query = $this->db->query("SELECT * FROM site_users WHERE id='" . $id . "'");
        if ($query->num_rows() > 0) {
            $data["user"] = $query->row();

            $query2 = $this->db->query("SELECT * FROM site_user_kisisel WHERE user_id='" . $id . "'");
            $data["kisisel"] = $query2->row();

            $query2 = $this->db->query("SELECT * FROM site_user_iletisim WHERE user_id='" . $id . "'");
            $data["iletisim"] = $query2->row();
            return $data;
        } else {
            show_404();
        }
    }

    function yetkiCheck() {

        $meslek = $this->uri->segment(1);
        $query = $this->db->query("SELECT id FROM site_meslek WHERE urlname='" . $meslek . "'");
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $meslek_id = $row->id;

            //Admin İse
            $query1 = $this->db->query("SELECT id FROM site_yetkilendirme WHERE user_id='" . $this->session->userdata("user_id") . "' AND meslek_id='" . $meslek_id . "' AND type='1'");
            if ($query1->num_rows() > 0) {
                //Admin
            } else {
                $query2 = $this->db->query("SELECT id FROM site_modules WHERE url_name='" . $this->uri->segment(3) . "'");
                $row2 = $query2->row();
                if ($query2->num_rows() > 0) {
                    $modul_id = $row2->id;

                    $query3 = $this->db->query("SELECT id FROM site_yetkilendirme WHERE user_id='" . $this->session->userdata("user_id") . "' and meslek_id='" . $meslek_id . "' and modul='" . $modul_id . "'");
                    if ($query3->num_rows() > 0) {
                        //Yetkili
                    } else {
                      show_404();
                    }
                } else {
                    show_404();
                }
            }
        } else {
           show_404();
        }
        echo $this->uri->segment(3);
    }

}

?>