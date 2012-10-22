<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class arkadas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $total_rows;
    }

    function add() {
        $id = $this->input->post("id");
        if ($id != $this->session->userdata("user_id")) {
            $query = $this->db->query("SELECT id,active FROM site_arkadas WHERE user_id='" . $this->session->userdata("user_id") . "' && friend_id='" . $id . "'  ");
            $row = $query->row();
            if ($query->num_rows() < 1) {
                $query = $this->db->query("INSERT INTO site_arkadas VALUES ('','" . $this->session->userdata("user_id") . "','" . $id . "','0')");
                if ($this->db->insert_id() > 0) {
                    echo '{"success":"true"}';
                } else {
                    echo '{"sucess":"false"}';
                }
            } else {
                echo ($row->active == 1) ? '{"success":"false","msg":"Zaten Arkadaşsınız!"}' : '{"success":"false","msg":"Daha önceden arkadaşlık teklif etmişssiniz!"}';
            }
        } else {
            echo '{"success":"false"}';
        }
    }

    function getFriends() {

        $cond = "WHERE user_id='" . $this->session->userdata("user_id") . "' AND site_arkadas.active='1'";
        if (isset($_GET["s"]) && $_GET["s"] != "") {
            $limit = "LIMIT " . $_GET["s"] . ",20";
        } else {
            $limit = "LIMIT 0,20";
        }

        $sql = "SELECT adsoyad,friend_id,image,site_arkadas.active,meslek FROM site_arkadas INNER JOIN site_users ON site_users.id=site_arkadas.friend_id";
        $query = $this->db->query($sql . " " . $cond);
        $this->total_rows = $query->num_rows();

        $query2 = $this->db->query($sql . " " . $cond . " ORDER BY site_arkadas.id DESC " . $limit . " ");
        return $query2->result();
    }

    function getFriendsSearch() {
        $cond = "";
        if (isset($_GET["q"]) && $_GET["q"] != "") {
            $cond.="WHERE site_users.id!='" . $this->session->userdata("user_id") . "' AND adsoyad like '%" . $_GET["q"] . "%'";
        }

        if (isset($_GET["s"]) && $_GET["s"] != "") {
            $limit = "LIMIT " . $_GET["s"] . ",20";
        } else {
            $limit = "LIMIT 0,20";
        }

        $sql = "SELECT site_users.id,site_users.adsoyad,site_users.image,site_meslek.name as meslek FROM site_users INNER JOIN site_meslek ON site_users.meslek=site_meslek.id";
        $query = $this->db->query($sql . " " . $cond);
        $this->total_rows = $query->num_rows();

        $query2 = $this->db->query($sql . " " . $cond . " " . $limit . " ");
        return $query2->result();
    }

    function admitFriend($user_id) {
        $answer = $this->input->post("answer");

        $query = $this->db->query("UPDATE site_arkadas SET active='" . $answer . "' WHERE user_id='" . $user_id . "' AND friend_id='" . $this->session->userdata("user_id") . "'");
        if ($answer == 1) {
            $query = $this->db->query("INSERT INTO site_arkadas VALUES ('','" . $this->session->userdata("user_id") . "','" . $user_id . "','1')");
            $query2 = $this->db->query("INSERT INTO site_bildirim (user_id,description,savedate,`read`) VALUES ('" . $user_id . "','<a href=\'" . base_url() . "kullanici/" . $this->session->userdata("user_id") . "\'>" . $this->session->userdata("user_adsoyad") . "</a> arkadaşlık isteğinizi kabul etti.',NOW(),'0')");

            $bildirim_id = $this->input->post("bildirim");
            $query3 = $this->db->query("SELECT adsoyad FROM site_users WHERE id='" . $user_id . "'");
            $row3 = $query3->row();
            $this->db->query("INSERT INTO site_bildirim (user_id,description,savedate,`read`) VALUES ('" . $this->session->userdata("user_id") . "','<a href=\'" . base_url() . "kullanici/" . $user_id . "\'>" . $row3->adsoyad . "</a> ile arkadaş oldunuz.',NOW(),'0') ");

            echo '{"success":"true","msg":"Arkadaşlık İsteğini kabul ettiniz."}';
        } else {
            echo '{"success":"false","msg":"Arkadaşlık isteğini reddettiniz!"}';
        }
    }

    function getFriendRequests() {
        $query = $this->db->query("SELECT site_arkadas.id,site_arkadas.active,user_id,site_users.adsoyad,site_users.image FROM site_arkadas INNER JOIN site_users ON site_users.id=site_arkadas.user_id WHERE friend_id='" . $this->session->userdata("user_id") . "' and site_arkadas.active='0'");
        return $query->result();
    }

}

?>
