<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Admin extends MY_Controller {

   function __construct() {
      parent::__construct();
      $this->template = "admin";
        ($this->session->userdata["admin_loggedIn"] == false) ? redirect(base_url() . "admin") : "";

      
   }

   function index() {
      
   }

   function users($action) {
      //İstatistik Kullanıcı Modeli
      $this->load->model("admin_user_model");
      
      if (isset($action[0]) && $action[0] != "") {
         switch ($action[0]) {
            //Günlük Ziyaretçi İstatistikleri
            case "day":
               $data["data"]=$this->admin_user_model->getDayStatsData();
               $this->load->view("admin/user/gunluk_istatistikler",$data);
               break;
            
            case "getDayStats":
               $this->template="ajax";
               $this->admin_user_model->getDayStats();
               break;
            
            //Aylık Ziyaretçi İstatistikleri
            case "month":
               $data["data"]=$this->admin_user_model->getMonthStatsData();
               $this->load->view("admin/user/aylik_istatistikler",$data);
               break;
            
            case "getMonthStats":
               $this->template="ajax";
               $this->admin_user_model->getMonthStats();
               break;
            
            //Yıllık Ziyaretçi İstatistikleri
            case "year":
               $data["data"]=$this->admin_user_model->getYearStatsData();
               $this->load->view("admin/user/yillik_istatistikler",$data);
               break;
            
            case "getYearStats":
               $this->template="ajax";
               $this->admin_user_model->getYearStats();
               break;
            
         }
      } else {
          $data["data"]=$this->admin_user_model->getDayStatsData();
          $this->load->view("admin/user/gunluk_istatistikler",$data);
      }
   }

}

?>