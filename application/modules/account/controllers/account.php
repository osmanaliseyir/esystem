<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class account extends MY_Controller {

   function __construct() {
      parent::__construct();
      $this->load->model("account_model");
      
   }
   
   function index(){
      
   }
   
   function signup(){
      $this->load->view("kayit_form");
   }
   
   /**
    * Bireysel Kullanıcı Kaydı
    */
   function bireysel(){
      $this->load->view("kayit_bireysel");
   }
   
   function bireyselSave(){
      $this->template="ajax";
      $this->account_model->bireyselSave();
   }
   
   /**
    * Kurumsal Firma Kaydı
    */
   function kurumsal(){
      $data["ils"]=$this->account_model->getIls();
      $data["ilces"]=$this->account_model->getIlces();
      $this->load->view("kayit_kurumsal",$data);
   }
   
   function kurumsalSave(){
      $this->template="ajax";
      $this->account_model->kurumsalSave();
   }
   
   function getIlcesJson(){
      $this->template="ajax";
      $this->account_model->getIlcesJson();
   }
   
   function forgotpassword(){
       $this->load->view("sifremi_unuttum");
   }
   
   function forgotPasswordCheck(){
       $this->template="ajax";
       $this->account_model->forgotPassword();
   }
   
   function activation(){
       $this->load->view("aktivasyon");
   }
   
   function activationCheck(){
       $this->template="ajax";
       $this->account_model->activationCheck();
   }

}
?>
