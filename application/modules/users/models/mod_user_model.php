<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class mod_user_model extends CI_Model {
    
    public $totalrows;
    
    function __construct() {
        parent::__construct();
        
    }

    function getUsers(){
      $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND adsoyad like '%".$_GET["q"]."%'";
        }
        $cond="WHERE meslek='".$this->meslekid."' ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",20";
        } else {
            $limit="LIMIT 0,20";
        }
      
       $sql="SELECT * FROM site_users";
       $query = $this->db->query($sql." ".$cond." ORDER BY savedate DESC");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit); 
       return $query2->result();
        
        
    }
    
    function getUser($id){
        $query = $this->db->query("SELECT * FROM site_users WHERE id='".$id."'");
        $query2 = $this->db->query("SELECT * FROM site_user_kisisel WHERE user_id='".$id."'");
        $query3 = $this->db->query("SELECT * FROM site_user_iletisim WHERE user_id='".$id."'");
        
        $data["kullanici"]=$query->row();
        $data["kisisel"]=$query2->row();
        $data["iletisim"]=$query3->row();
        
        return $data;        
    }
    
    function editsave($id){
        //Kişisel Bilgiler
        $adsoyad  = addslashes($this->input->post("adsoyad"));
        $active  = $this->input->post("active");
        $cinsiyet = addslashes($this->input->post("cinsiyet"));
        $dogumtarihi = $this->input->post("dtyil")."-".$this->input->post("dtay")."-".$this->input->post("dtgun");
        
        //İletişim Bilgileri
        $email = addslashes($this->input->post("email"));
        $ceptel = addslashes($this->input->post("ceptel"));
        $evtel = addslashes($this->input->post("evtel"));
        $istel = addslashes($this->input->post("istel"));
        $isteldahili = addslashes($this->input->post("isteldahili"));
        $il = $this->input->post("il");        
        $password = $this->input->post("password");        
        $password2 = $this->input->post("password2");        
        
        if($password!="" && $password2!="" && $password==$password2){
            $passQuery=",password='".md5($password)."'";
        } else {
            $passQuery="";
        }
        
        
        if($adsoyad!="" && $email!=""){
            
           $this->db->query("UPDATE site_users SET adsoyad='".$adsoyad."' ".$passQuery." ,email='".$email."',updatedate=NOW(), active='".$active."' WHERE id='".$id."'"); 
           $this->db->query("UPDATE site_user_kisisel SET cinsiyet='".$cinsiyet."',dogumtarihi='".$dogumtarihi."' WHERE user_id='".$id."'"); 
           $this->db->query("UPDATE site_user_iletisim SET evtel='".$evtel."',ceptel='".$ceptel."',istel='".$istel."', isteldahili='".$isteldahili."',il='".$il."' WHERE user_id='".$id."'"); 
           
                echo '{"success":"true","msg":"Kullanıcı Bilgileri Başarıyla Düzenlenmiştir."}';
            
            
            
        } else {
            echo '{"success":"false","msg":"Adınızı ve E-Posta adresi girmelisiniz!"}';
        }
        
    }
    
    function delete($id) {
      $query = $this->db->query("DELETE FROM site_users WHERE id='$id'");
      echo ($this->db->affected_rows() > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }
}
?>
