<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * Admin User Detail
     */

    function userDetail($user_id) {
        $user_id = intval($user_id);
        $query = $this->db->get_where("sys_users", array("id" => $user_id));
        return $query->row();
    }

    /*
     * Şifre Değiştirme Kontrolü
     */

    function cpCheck() {
        $password = $this->input->post("password");
        $passwordnew = $this->input->post("passwordnew");
        $passwordnew2 = $this->input->post("passwordnew2");

        //Böyle bir kullanıcı var mı?
        $isUser = $this->db->query("SELECT id FROM sys_users WHERE active='1' AND id='" . $this->session->userdata["user_id"] . "' AND password='" . md5($password) . "'");

        if ($password != "") {
            if ($passwordnew != "") {
                if ($passwordnew2 != "") {
                    if ($passwordnew == $passwordnew2) {
                        if ($isUser->num_rows() == 1) {
                            $query = $this->db->query("UPDATE sys_users SET password='" . md5($passwordnew) . "' WHERE id='" . $this->session->userdata["user_id"] . "'");
                            if ($this->db->affected_rows() > 0) {
                                echo '{"success":"true", "msg":"' . lang("Şifreniz Başarıyla Değiştirilmiştir!") . '"}';
                            } else {
                                echo '{"success":"false","msg":"' . lang("Şifreniz Değiştirilemedi!") . '"}';
                            }
                        } else {
                            echo '{"success":"false","msg":"' . lang("Şuan ki şifrenizi yanlış girdiniz!") . '"}';
                        }
                    } else {
                        echo '{"success":"false","msg":"' . lang("Yeni Girmiş Olduğunuz Şifreler Uyuşmuyor!") . '"}';
                    }
                } else {
                    echo '{"success":"false","msg":"' . lang("Yeni Şifrenizin Tekrarını Giriniz") . '"}';
                }
            } else {
                echo '{"success":"false","msg":"' . lang("Eski Şifrenizi Giriniz") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("Yeni Şifrenizi Giriniz") . '"}';
        }
    }

}

?>
