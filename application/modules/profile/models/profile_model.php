<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class profile_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }

    function changepasswordCheck(){
        $oldpass=$this->input->post("oldpass");
        $newpass=$this->input->post("newpass");
        $newpass2=$this->input->post("newpass2");
        if($oldpass!=""){
            if($newpass!=""){
                if($newpass2!=""){
                    if($newpass==$newpass2){
                        if(strlen($newpass)>3){
                            
                            $query=$this->db->query("SELECT id FROM site_users WHERE id='".$this->session->userdata("user_id")."' and password='".md5($oldpass)."'");
                            if($query->num_rows()>0){
                                 $this->db->query("UPDATE site_users SET password='".md5($newpass)."'");
                                 if($this->db->affected_rows()>0){
                                          echo '{"success":"true","msg":"Şifreniz Başarıyla Değiştirilmiştir!"}';
                                 } else {
                                        echo '{"success":"false","msg":"Hata : Şifreniz Değiştirelemedi!"}';
                                 }
                            } else {
                                  echo '{"success":"false","msg":"Şuanki şifrenizi yanlış girdiniz!"}';
                            }                         
                        }else {
                             echo '{"success":"false","msg":"Yeni Şifrenizin uzunluğu en az 4 karakter olmalı!"}';
                        }
                    } else {
                         echo '{"success":"false","msg":"Girmiş olduğunuz şifreler birbiri ile uyuşmuyor!"}';
                    } 
                } else {
                    echo '{"success":"false","msg":"Yeni Şifrenizi Tekrar Giriniz!"}';
                }
            } else {
                echo '{"success":"false","msg":"Yeni Şifrenizi Giriniz!"}';
            }
        } else {
            echo '{"success":"false","msg":"Eski Şifrenizi Giriniz!"}';
        }
    }
    
    /**
     * Bilgilerimi Getirir
     */
    function getMyInformation(){
        $user_id=$this->session->userdata("user_id");
        if($user_id!="" && intval($user_id)>0){
            $query = $this->db->query("SELECT * FROM site_users WHERE id='".$user_id."'");
            $query2 = $this->db->query("SELECT * FROM site_user_kisisel WHERE user_id='".$user_id."'");
            $query3 = $this->db->query("SELECT * FROM site_user_iletisim WHERE user_id='".$user_id."'");
            
            $data["user"]=$query->row();
            $data["kisisel"]=$query2->row();
            $data["iletisim"]=$query3->row();
            return $data;
        } else {
            return false;
        }   
    }
    
    /**
     * Kaydet
     */
    function saveMyInformation(){
        //Kişisel Bilgiler
        $adsoyad  = addslashes($this->input->post("adsoyad"));
        $cinsiyet = addslashes($this->input->post("cinsiyet"));
        $dogumtarihi = $this->input->post("dtyil")."-".$this->input->post("dtay")."-".$this->input->post("dtgun");
        $kisiselvisible = ($this->input->post("kisiselvisible")!="") ? $this->input->post("kisiselvisible") : 0;
        
        //İletişim Bilgileri
        $email = addslashes($this->input->post("email"));
        $ceptel = addslashes($this->input->post("ceptel"));
        $evtel = addslashes($this->input->post("evtel"));
        $istel = addslashes($this->input->post("istel"));
        $isteldahili = addslashes($this->input->post("isteldahili"));
        $il = $this->input->post("il");
        $iletisimvisible= ($this->input->post("iletisimvisible")!="") ? $this->input->post("iletisimvisible") : 0;
        
        //İş Bilgileri
        $meslek = $this->input->post("meslek");
        
        if($adsoyad!="" && $email!=""){
            
           $this->db->query("UPDATE site_users SET adsoyad='".$adsoyad."', meslek='".$meslek."', email='".$email."',updatedate=NOW() WHERE id='".$this->session->userdata("user_id")."'"); 
           $this->db->query("UPDATE site_user_kisisel SET cinsiyet='".$cinsiyet."',dogumtarihi='".$dogumtarihi."',kisiselvisible='".$kisiselvisible."' WHERE user_id='".$this->session->userdata("user_id")."'"); 
           $this->db->query("UPDATE site_user_iletisim SET evtel='".$evtel."',ceptel='".$ceptel."',istel='".$istel."', isteldahili='".$isteldahili."',il='".$il."',iletisimvisible='".$iletisimvisible."' WHERE user_id='".$this->session->userdata("user_id")."'"); 
           
                echo '{"success":"true","msg":"Bilgileriniz Başarıyla Düzenlenmiştir."}';
            
            
            
        } else {
            echo '{"success":"false","msg":"Adınızı ve E-Posta adresinizi girmelisiniz!"}';
        }
        
    }
    
    function user_logout(){
        
        //Session ları yok et
        $this->session->sess_destroy();  
        
        //Cookileri yok et
        $this->load->helper("cookie");
        delete_cookie('e-meslek');
        
        redirect(base_url());
    }
    
}
?>
