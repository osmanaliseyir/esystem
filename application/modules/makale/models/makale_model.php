<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class makale_Model extends CI_Model {

 function __construct() {
        parent::__construct();
        $total_rows;
    }
    
    function getMakaleler(){
       
        $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["category"]) && $_GET["category"]!=""){
             $cond.=" AND category='".$_GET["category"]."'";
        }
        $cond="WHERE active='1' AND site_makale_category.meslek='".$this->meslekid."' ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("haber_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("haber_rowperpage");
        }
       
       $sql="SELECT site_makale.id,site_makale.name, image,site_makale_category.name as categoryname,site_makale.subtitle,site_makale.savedate,readnum FROM site_makale INNER JOIN site_makale_category ON site_makale.category=site_makale_category.id";
       $query = $this->db->query($sql." ".$cond." ORDER BY savedate DESC");
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ORDER BY savedate DESC ".$limit); 
       return $query2->result();
    }
    
    function getMakale($id){
        $query=$this->db->query("SELECT site_makale.*,site_makale_category.name as categoryname FROM site_makale INNER JOIN site_makale_category ON site_makale.category=site_makale_category.id WHERE site_makale.id='".intval($id)."'");
        return $query->row();
    }
    
    function getCategories() {
      $query = $this->db->query("SELECT * FROM site_makale_category WHERE meslek='".$this->meslekid."'");
      return $query->result();
   }
     

}
 
?>

