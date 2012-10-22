<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class login extends MY_Controller {

   function __construct() {
      parent::__construct();
   }
   
   function index(){
      $this->load->view("giris_form");
   }
   
   function check(){
      $this->template="ajax";
      $this->load->model("login_model");
      $this->login_model->check();
   }

}

?>
