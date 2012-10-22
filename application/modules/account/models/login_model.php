<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class login_model extends CI_Model {

   function __construct() {
      parent::__construct();
   }
   
   function check(){
      $email = $this->input->post("email");
        $password = $this->input->post("password");

        $query = $this->db->query("SELECT id,email,adsoyad,type FROM site_users WHERE email=" . $this->db->escape($email) . " AND password='" . md5($password) . "'");
        if ($email != "") {
            if ($password != "") {
                if ($query->num_rows() == 1) {
                
                    //Sessionları oluşturuyoruz..
                    $row = $query->row();
                    
                    echo '{"success":"true", "type":"'.$row->type.'"}';
                    
                  
                     
                    $sessions["user_id"] = $row->id;
                    $sessions["user_type"] = $row->type;
                    $sessions["user_adsoyad"] = $row->adsoyad;
                    $sessions["user_email"] = $row->email;
                    $sessions["user_loggedIn"] = true;
                    $this->session->set_userdata($sessions);
                   
                    
                } else {
                    echo '{"success":"false","msg":"' . lang("Kullanıcı adı ve şifreniz uyuşmuyor!") . '"}';
                }
            } else {
                echo '{"success":"false","msg":"' . lang("Şifrenizi Giriniz!") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("E-posta Adresinizi giriniz!") . '"}';
        }
   }

}

?>
