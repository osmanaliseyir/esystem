<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class haber_Model extends CI_Model {

 function __construct() {
        parent::__construct();
        $total_rows;
    }
    
    function getHaberler(){
       
        $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $cond.=" AND category='".$_GET["category"]."'";
        }
        $cond="WHERE active='1' AND site_haber_category.meslek='".$this->meslekid."' ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("haber_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("haber_rowperpage");
        }
       
       $sql="SELECT site_haber.* FROM site_haber INNER JOIN site_haber_category ON site_haber.category=site_haber_category.id";
       $query = $this->db->query($sql." ".$cond." ORDER BY savedate DESC");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit); 
       return $query2->result();
    }
    
    function getHaber($id){
        $query=$this->db->query("SELECT * FROM site_haber WHERE id='".intval($id)."'");
        return $query->row();
    }
     

}
 
?>

