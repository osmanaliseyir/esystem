<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class firma_Model extends CI_Model {

 function __construct() {
        parent::__construct();
        $total_rows;
    }
    
    /**
     * Firma Categorileri getirir
     * @param int $id Category id si
     * @return object 
     */
    function getCategories($id=""){
       $cond=($id!="") ? "WHERE id='".$id."'" : "WHERE 1=1";
       $query = $this->db->query("SELECT id,name FROM site_firma_category ".$cond."");
       return $query->result();
    }
    
    function getPhotos(){
       $user_id=$this->session->userdata("user_id");
       $query = $this->db->query("SELECT site_firma_resim.* FROM site_firma_resim INNER JOIN site_firma ON site_firma.id=site_firma_resim.firma_id WHERE site_firma.user_id='".$user_id."' ");
       return $query->result();
    }
    
    function getCategory($url=""){
       $query = $this->db->query("SELECT id,name FROM site_firma_category WHERE url='".$url."'");
       return $query->row();
    }
    
    function getCategoriesDropDown(){
        $data=array(""=>lang("Tüm Kategoriler"));
       $query = $this->db->query("SELECT id,name FROM site_firma_category");
       foreach($query->result() as $row){
           $data[$row->id]=$row->name;
       }
       return $data;
    }
    
    function getFirmas($cond=""){
       $cond="";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $cond.=" AND name like '%".$_GET["q"]."%'";
        }
        if(isset($_GET["harf"]) && $_GET["harf"]!=""){
            $cond.=" AND name like '".$_GET["harf"]."%'";
        }
         if(isset($_GET["category"]) && $_GET["category"]!=""){
             $cond.="AND category='".$_GET["category"]."'";
        }
        $cond="WHERE 1=1 ".$cond;
        
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit="LIMIT ".$_GET["s"].",".$this->config->item("firma_rowperpage");
        } else {
            $limit="LIMIT 0,".$this->config->item("firma_rowperpage");
        }

        
       $sql="SELECT * FROM site_firma_view";
       $query = $this->db->query($sql." ".$cond);
       $this->total_rows=$query->num_rows();
      
       $query2=$this->db->query($sql." ".$cond." ".$limit); 
       return $query2->result();
    }
    
    function getFirma($id){
        $query=$this->db->query("SELECT * FROM site_firma_view WHERE id='".intval($id)."'");
        return $query->row();
    }
    
    function getFirmaIlans($id){
        $query=$this->db->query("SELECT user_id FROM site_firma WHERE id='".$id."' ");
        $row=$query->row();
        $user_id=$row->user_id;
        $query=$this->db->query("SELECT id,name,categoryname,category,savedate FROM site_ilan_view WHERE user_id='".$user_id."' ORDER BY savedate DESC");
        return $query->result();
    }
   
 
   
   
    

}
 
?>

