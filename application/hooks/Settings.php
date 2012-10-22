<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings {

    public $CI;

    function __construct() {
        $this->CI = &get_instance();
    }

    /*
     * Ön tanımlı değişkenlerimizi ayarlıyoruz.. sys_config tablosu içerisindekileri
     */

    function setConstants() {
        //Ayarlar
        $query = $this->CI->db->query("SELECT * FROM sys_config");
        foreach ($query->result() as $row) {
            $this->CI->config->set_item($row->option_name, $row->option_value);
        }

        $this->CI->meslekname = "";
        $this->CI->meslekid = "";
        if ($this->CI->uri->segment(1) != "") {
            $query = $this->CI->db->query("SELECT id,name FROM site_meslek WHERE urlname='" . $this->CI->uri->segment(1) . "'");
            $row = $query->row();
            if ($query->num_rows() > 0) {
                $this->CI->meslekid = $row->id;
                $this->CI->meslekname = $row->name;
            }
        }
    }

}

?>
