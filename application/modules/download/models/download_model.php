<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class download_Model extends CI_Model {

    public $total_rows;

    function __construct() {
        parent::__construct();
    }

    function getDownloads($cond="") {
        $cond = ($cond != "") ? $cond : "";
        if (isset($_GET["q"]) && $_GET["q"] != "") {
            $cond.= "AND (name like '%" . $_GET["q"] . "%'  or description like '%".$_GET["q"]."%' ) ";
        }

        if (isset($_GET["s"]) && $_GET["s"] != "") {
            $limit = "LIMIT " . $_GET["s"] . ",20";
        } else {
            $limit = "LIMIT 0,20";
        }

        $cond = "WHERE 1=1 " . $cond;

        $sql = "SELECT * FROM site_download ";
        $query = $this->db->query($sql . $cond . " ORDER BY savedate DESC");
        $this->total_rows = $query->num_rows();

        $query2 = $this->db->query($sql . $cond . " ORDER BY savedate DESC " . $limit);
        return $query2->result();
    }

    function getCategories() {
        $query = "SELECT c.id,c.name,c.description, count(d.id) as sayi  FROM site_download_category as c LEFT JOIN site_download as d ON d.category=c.id WHERE c.meslek='" . $this->meslekid . "' GROUP BY c.id";
        $select = $this->db->query($query);
        return $select->result();
    }

    function getCategoryDownloads($id) {

        $query = $this->db->query("SELECT * FROM site_download_category WHERE id='".$id."'");
        ($query->num_rows != 1) ? show_404() : "";

        $data["kategori"] = $query->row();
        $data["dosyalar"]=$this->getDownloads(" AND category='".$id."'");
        
        return $data;
    }

}

?>