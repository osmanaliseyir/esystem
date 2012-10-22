<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class admin_user_Model extends CI_Model {

   function __construct() {
      parent::__construct();
      
      //Dil Dosyamızı Takvim için çekiyoruz..
      $this->lang->load("calendar", $this->session->userdata["user_lang"]);
   }

   /**
    * Bir tarihte veya iki tarih aralıgındaki Tekil ziyaterçi sayısını döndürür
    * @param date $date
    * @param date $date2
    * @return int Tekil Ziyaretçi Sayısı
    */
   function getUniqueHit($date, $date2="") {
      $condition = ($date2 != "") ? "tarih>='$date' and tarih<='$date2'" : "tarih='$date'";
      $query = $this->db->query("SELECT id FROM sys_hits WHERE $condition");
      return $query->num_rows();
   }

   /**
    * Bir tarihte veya iki tarih aralıgındaki Çoğul Ziyaterçi sayısını döndürür
    * @param date $date
    * @param date $date2
    * @return int Çoğul Ziyaretçi Sayısı 
    */
   function getTotalHit($date, $date2="") {
      $condition = ($date2 != "") ? "tarih>='$date' and tarih<='$date2'" : "tarih='$date'";
      $query = $this->db->query("SELECT sum(hit) as total FROM sys_hits WHERE $condition");
      $total = $query->row();
      return ($total->total > 0) ? $total->total : 0;
   }

   /**
    * Günlük Tekil ve Çoğul Ziyaretçiler
    */
   function getDayStats() {
      
      $json = '{"label":"'.lang("Günlük Tekil Hit").' ' . lang("cal_".strtolower(date("F"))) . ' Ayı","data":[';
      for ($i = date("d"); $i > 0; $i--) {
         $json.="[" . intval($i) . "," . $this->getUniqueHit(date("Y") . "-" . date("m") . "-" . $i) . "]";
         ($i > 1) ? $json.="," :"";
      }

      $json.=']},';
      $json.= '{"label":"'.lang("Günlük Çoğul Hit").' ' . lang("cal_".strtolower(date("F")))  . ' Ayı","data":[';
      for ($i = date("d"); $i > 0; $i--) {
         $json.="[" . intval($i) . "," . $this->getTotalHit(date("Y") . "-" . date("m") . "-" . $i) . "]";
         ($i > 1) ? $json.="," :"";
      }
      $json.=']}';
      
      echo '{"result":['.$json.']}';
   }
   
   function getDayStatsData(){
      $data=array();
      for ($i = date("d"); $i > 0; $i--) {
       $data[$i]["gun"]=$i;
       $data[$i]["ay"]=$i." ".lang("cal_".strtolower(date("F")));
       $data[$i]["tekil"]=$this->getUniqueHit(date("Y") . "-" . date("m") . "-" . $i);
       $data[$i]["cogul"]=$this->getTotalHit(date("Y") . "-" . date("m") . "-" . $i);
      }
      return $data;
   }
   
   /**
    * Aylık Tekil ve Çoğul Ziyaretçiler
    */
   function getMonthStats() {
      
     $json = '{"label":"Aylık Tekil Hit ' . date("Y") . ' Yılı","data":[';
      for ($i = date("m"); $i > 0; $i--) {
         $monthdays=  cal_days_in_month(CAL_GREGORIAN, $i, date("Y"));
         $json.="[" . intval($i) . "," . $this->getUniqueHit(date("Y")."-".$i."-01", date("Y")."-".$i."-".$monthdays) . "]";
         ($i > 1) ? $json.="," :"";
      }

      $json.='] },';

      $json.= '{"label":"Aylık Çoğul Hit ' . date("Y") . ' Yılı","data":[';
      for ($i = date("m"); $i > 0; $i--) {
         $monthdays=  cal_days_in_month(CAL_GREGORIAN, $i, date("Y"));
         $json.="[" . intval($i) . "," . $this->getTotalHit(date("Y")."-".$i."-01", date("Y")."-".$i."-".$monthdays) . "]";
         ($i > 1) ? $json.="," :"";
      }
      $json.='] }';
      echo '{"result":['.$json.']}';
   }
   
   function getMonthStatsData(){
      $data=array();
      for ($i = date("m"); $i > 0; $i--) {
       $monthdays=  cal_days_in_month(CAL_GREGORIAN, $i, date("Y"));
       $data[$i]["ay"]=$i;
       $data[$i]["yil"]=$i." ".date("Y");
       $data[$i]["tekil"]=$this->getUniqueHit(date("Y")."-".$i."-01", date("Y")."-".$i."-".$monthdays);
       $data[$i]["cogul"]=$this->getTotalHit(date("Y")."-".$i."-01", date("Y")."-".$i."-".$monthdays);
      }
      return $data;
 
   }
   
   function getYearStats() {

      $json = '{"label":"Yıllık Tekil Hit","data":[';
      for ($i = date("Y"); $i > 2010; $i--) {
         $json.="[" . intval($i) . "," . $this->getUniqueHit($i."-01-01", $i."-12-31") . "]";
         ($i > 2011) ? $json.="," :"";
      }

      $json.='] },';

      $json.= '{"label":"Yıllık Çoğul Hit ' . date("Y") . ' Yılı","data":[';
      for ($i = date("Y"); $i > 2010; $i--) {
         $json.="[" . intval($i) . "," . $this->getTotalHit($i."-01-01", $i."-12-31") . "]";
         ($i > 2011) ? $json.="," :"";
      }
      $json.='] }';
      echo '{"result":['.$json.']}';
   }
   
   
   function getYearStatsData(){
      $data=array();
      for ($i = date("Y"); $i > 2010; $i--) {
       $data[$i]["yil"]=$i;
       $data[$i]["tekil"]=$this->getUniqueHit($i."-01-01", $i."-12-31");
       $data[$i]["cogul"]=$this->getTotalHit($i."-01-01", $i."-12-31");
      }
      return $data;
 
   }
   
   
   
   

}

?>
