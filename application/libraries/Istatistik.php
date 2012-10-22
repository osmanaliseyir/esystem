<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Istatistik {
     
   function getUniqueHit($date,$date2=""){
      $condition=($date2!="") ? "tarih>='$date' and tarih<='$date2'" : "tarih='$date'";
      $query= $this->db->query("SELECT id FROM sys_hits WHERE $condition");
      return $query->num_rows();
   }
   
   function getTotalHit($date,$date2=""){
      $condition=($date2!="") ? "tarih>='$date' and tarih<='$date2'" : "tarih='$date'";
      $query= $this->db->query("SELECT sum(hit) as total FROM sys_hits WHERE $condition");
      $row=$query->row();
      return ($row->total>0) ? $row->total : 0 ;
   }
      
}

?>
