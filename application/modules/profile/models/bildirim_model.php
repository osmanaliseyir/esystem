<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
class bildirim_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $total_rows;
    }
    
    function getBildirims(){
        
        
        $cond="WHERE `user_id`='".$this->session->userdata["user_id"]."'";
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",20";
        } else {
            $limit="LIMIT 0,20";
        }
       
       $sql="SELECT * FROM site_bildirim";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit." "); 
       return $query2->result();
    }
    
    
       
    function delete($id){
        $query=$this->db->query("DELETE FROM site_bildirim WHERE id='$id'");
        if($this->db->affected_rows()>0){
            echo '{"success":"true"}';
        } else {
            echo '{"success":"false"}';
        }
    }
}
?>
