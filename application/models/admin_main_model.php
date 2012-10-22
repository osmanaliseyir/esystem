<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class admin_main_model extends CI_Model {

    function __construct() {
        parent::__construct();
       // $this->load->database();
    }

    function logincheck() {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $query = $this->db->query("SELECT id,username,adsoyad,type FROM sys_users WHERE username=" . $this->db->escape($username) . " AND password='" . md5($password) . "'");
        if ($username != "") {
            if ($password != "") {
                if ($query->num_rows() == 1) {
                
                    //Sessionları oluşturuyoruz..
                    $row = $query->row();
                     
                    $sessions["admin_id"] = $row->id;
                    $sessions["admin_type"] = $row->type;
                    $sessions["admin_adsoyad"] = $row->adsoyad;
                    $sessions["admin_name"] = $row->username;
                    $sessions["admin_loggedIn"] = true;
                    $this->session->set_userdata($sessions);
                    redirect(base_url()."admin/dashboard");
                    
                } else {
                    return lang("Kullanıcı adı ve Şifreniz Uyuşmuyor");
                }
            } else {
                return lang("Şifrenizi Giriniz!");
            }
        } else {
           return lang("E-posta Adresinizi giriniz!");
        }
        
    }

    function isLoggedIn() {
        if (isset($this->session->userdata["admin_loggedIn"])) {
            $loggedIn = $this->session->userdata["admin_loggedIn"];
            if ($loggedIn == true) {
                return true;
            } else {
                return false;
            }
        }
    }

    function languages() {
        $query = $this->db->query("SELECT * FROM sys_langs ORDER BY `order` ASC");
        return $query->result();
    }

    function setLang($language) {
        $query = $this->db->query("SELECT lang_name FROM sys_langs WHERE lang_short='" . $language[0] . "'");
        $row = $query->row();
        $this->session->set_userdata("user_lang", $row->lang_name);
    }

}?>