<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
class mesaj_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $total_rows;
    }
    
    function getMessages(){
        
        $cond="WHERE `to`='".$this->session->userdata["user_id"]."'";
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",20";
        } else {
            $limit="LIMIT 0,20";
        }
       
       $sql="SELECT site_messages.*,site_users.adsoyad as sender FROM site_messages INNER JOIN site_users ON site_users.id=site_messages.from";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit." "); 
       return $query2->result();
    }
    
    function getMessage($id){
        $query=$this->db->query("SELECT site_messages.*,site_users.adsoyad as sender FROM site_messages INNER JOIN site_users ON site_users.id=site_messages.from WHERE site_messages.id='".$id."' AND `to`='".$this->session->userdata["user_id"]."' ");
        return $query->row();
    }
    
    function sendMessage(){
        $from=$this->session->userdata["user_id"];
        $to=$this->input->post("to");
        $message=$this->input->post("message");
        $this->db->query("INSERT INTO site_messages VALUES ('','".$to."','".$from."','".lang("İlan Başvurusu")."','".$message."',NOW(),'0')");
        echo ($this->db->insert_id()>0) ?  '{"success":"true"}' : '{"success":"false"}';
    }
    
    function send(){
        $to=$this->input->post("to");
        $from=$this->session->userdata("user_id");
        $name=addslashes($this->input->post("name"));
        $description=addslashes($this->input->post("description"));
        $this->db->query("INSERT INTO site_messages VALUES ('','".$to."','".$from."','".$name."','".$description."',NOW(),'0')");
        echo ($this->db->insert_id()>0) ? '{"success":"true"}' : '{"success":"false"}';
        
    }
    
    function delete($id){
        $query=$this->db->query("DELETE FROM site_messages WHERE id='$id'");
        if($this->db->affected_rows()>0){
            echo '{"success":"true"}';
        } else {
            echo '{"success":"false"}';
        }
    }
    
    function searchUser(){
        $filter=$this->input->post("filter");
        $query = $this->db->query("SELECT id,adsoyad FROM site_users WHERE adsoyad like '%".$filter."%' ");
        $data=json_encode($query->result());
        echo '{"success":"true","data":'.$data.'}';
    }

}
?>
