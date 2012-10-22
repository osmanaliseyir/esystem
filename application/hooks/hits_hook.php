<?php

if (!defined('BASEPATH'))
   exit('No direct script access allowed');

class Hits {

   function __construct() {
      $this->CI = &get_instance();

      //Hitleri giriyoruz..
      $this->setHits();

      //Online Kullanıcıları giriyoruz..
      $this->onlineUsers();
   }

   /*
    * @desc hitleri düzenler
    */

   function setHits() {
      $ip = $_SERVER["REMOTE_ADDR"];
      $today = date("Y-m-d");
      $query = $this->CI->db->query("SELECT id FROM sys_hits WHERE ip='" . $ip . "' and tarih='" . $today . "'");
      if ($query->num_rows() > 0) {
         $row = $query->row();
         $update = $this->CI->db->query("UPDATE sys_hits SET hit=hit+1 WHERE id='" . $row->id . "'");
      } else {
         $insert = $this->CI->db->query("INSERT INTO sys_hits VALUES ('','" . $ip . "','1','" . $today . "')");
      }
   }

   /*
    * @desc online kullanıcıları düzenler
    */

   function onlineUsers() {
      $time = time();
      
      //Zaman Aşımı Süresi = 1 dakika (60 saniye x 1)
      $outtime = ($time - 60);

      $values["time"] = $time;
      $values["ip"] = $_SERVER["REMOTE_ADDR"];
      $values["type"] = (isset($this->CI->session->userdata["loggedIn"])) ? 1 : 0;
      $values["user_id"] = (isset($this->CI->session->userdata["user_id"])) ? $this->CI->session->userdata["user_id"] : null;
      
      $this->CI->db->insert("sys_onlineusers", $values);

      //süre aşımına ugrasyanları siliyoruz!
      $this->CI->db->query("DELETE FROM sys_onlineusers WHERE time<'" . $outtime . "'");
   }

}

?>
