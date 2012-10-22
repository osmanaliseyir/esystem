<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    function __construct() {
        parent::__construct();
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";
        $this->template = "admin";
    }

    function index() {
        $this->load->model("admin_model");

        //Kullanıcı Bilgileri
        $user_id = $this->session->userdata("admin_id");
        $data["data"] = $this->admin_model->userDetail($user_id);
        $this->load->view("admin/profilim", $data);
    }

    /*
     * Şifre Değiştirme Sayfası ( Change Password )
     */

    function cp() {
        $this->load->view("admin/sifre_degistir");
    }

    /*
     * Şifre Değiştirme Kontrolü
     */

    function cpCheck() {
        $this->template = "none";
        $this->load->model("admin_model");
        $this->admin_model->cpCheck();
    }

    /*
     * Profil Değiştir
     */

    function changeProfile() {
        $this->load->model("admin_model");
        //Kullanıcı Bilgileri
        $user_id = $this->session->userdata("admin_id");
        $data["data"] = $this->admin_model->userDetail($user_id);
        $this->load->view("admin/profil_degistir", $data);
    }

    /*
     * Profile Değiştirme Kontrölü
     */

    function changeProfileCheck() {
        $this->template = "none";
        $adsoyad = $this->input->post("adsoyad");
        if ($adsoyad != "") {
            $query = $this->db->query("UPDATE sys_users SET adsoyad='" . $adsoyad . "' WHERE id='" . $this->session->userdata["admin_id"] . "'");
            if ($this->db->affected_rows() > 0) {
                echo '{"success":"true","msg":"' . lang("Profil Bilgileriniz Başarıyla Düzenlenmiştir.") . '"}';
            } else {
                echo '{"success":"false","msg":"' . lang("Herhangi Değişiklik Yapılmadı!") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("Adınızı ve Soyadınızı Giriniz!") . '"}';
        }
    }

}

?>
