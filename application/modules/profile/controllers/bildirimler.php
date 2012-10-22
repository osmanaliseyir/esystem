<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

class bildirimler extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("bildirim_model");
    }
    
    function index(){
        $data["data"]=$this->bildirim_model->getBildirims();
        $this->load->view("bildirimler/bildirimler",$data);
        $query = $this->db->query("UPDATE site_bildirim SET `read`='1' WHERE `user_id`='".$this->session->userdata["user_id"]."'");

    }
    
    function delete($args){
        if(isset($args[0]) && isset($_GET["token"])){
            if(setToken($args[0])==$_GET["token"]){
                $this->template="ajax";
                $this->bildirim_model->delete($args[0]);
            } else {
                show_404();
            }
         } else {
             show_404();
         }
    }
    
}
?>
