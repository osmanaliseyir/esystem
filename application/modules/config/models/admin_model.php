<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class admin_model extends CI_Model {

   function __construct() {
      parent::__construct();
   }

   function config($type="site") {
      $query = $this->db->query("SELECT option_name,option_value FROM sys_config WHERE option_type='" . $type . "' ");
      foreach ($query->result() as $row) {
         $data[$row->option_name] = $row->option_value;
      }
      return $data;
   }

   function languages() {
      $query = $this->db->query("SELECT * FROM sys_langs ORDER BY `order` ASC");
      foreach ($query->result() as $row) {
         $data[$row->lang_name] = $row->lang_description;
      }
      return $data;
   }

   function save() {
      $affectedRows = 0;
      $data = $this->input->post(null, TRUE);
      foreach ($data as $key => $value) {
         $this->db->query("UPDATE sys_config SET option_value='" . $value . "' WHERE option_name='" . $key . "' ");
         ($this->db->affected_rows() > 0) ? $affectedRows++ : '';
      }
      echo ($affectedRows > 0) ? '{"success":"true"}' : '{"success":"false"}';
   }

}

?>
