<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class contact extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
     $securitycode=rand(100000,999999);
     $data["securitycode"]=$securitycode;	
     $this->session->set_userdata('securitycode', $securitycode);
	 $this->load->view("iletisim",$data);
    }

    function save() {
        $this->template = "ajax";
        $adsoyad = $this->input->post("adsoyad");
        $email = $this->input->post("email");
        $tel = $this->input->post("tel");
        $securitycode = $this->input->post("securitycode");
        $name = addslashes($this->input->post("name"));
        $description = addslashes($this->input->post("description"));
        
       
        if ($adsoyad != "" && $email != "" && $name != "") {
            if($securitycode==$this->session->userdata("securitycode")){
            $this->load->library('email');

            $config["mailtype"] = "html";
            $this->email->initialize($config);

            $this->email->from('' . $adsoyad . '', '' . $email. '');
            $this->email->to($this->config->item("admin_email"),$this->config->item("admin_name"));
            $this->email->subject('İletişim Mesajı');
            $html = "İletişim Mesajı<br/>-----------------------<br/>";
            $html.="<b>" . $name . "<b><br/>";
            $html.="" . $description . "<br/><br/>";
            $html.=lang("Adsoyad").": ".$adsoyad."<br/>";
            $html.=lang("Telefon").": ".$tel."<br/>";
            $html.=lang("Email").": ".$email."<br/>";
            $this->email->message($html);
            $this->email->send();

            $this->db->query("INSERT INTO sys_contact VALUES ('','" . $name . "','" . $description . "','" . $adsoyad . "','" . $email . "','" . $tel . "',NOW() )");
            echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success","false"}';
            
            } else {
                echo '{"success":"false","msg":"' . lang("Güvenlik Kodunu Yanlış Girdiniz!") . '"}';
            }
        } else {
            echo '{"success":"false","msg":"' . lang("Gerekli Alanları Doldurunuz!") . '"}';
        }
    }

}
?>