<?php

defined("BASEPATH") or die("Direkt Erişim Yok!");

class meslek_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }

    function getMesleks(){
        $data=array(""=>"Seçiniz");
        $query=$this->db->query("SELECT id,name FROM site_meslek WHERE active='1' ORDER BY name ASC");
        foreach ($query->result() as $row){
            $data[$row->id]=$row->name;
        }
        return $data;
    }

}
?>
