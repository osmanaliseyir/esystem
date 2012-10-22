<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class download_mod_Model extends CI_Model {

 function __construct() {
        parent::__construct();
    }
    
    function getDownloads($meslekID){
        $where  = "";
        if(isset($_GET["q"]) && $_GET["q"]!=""){
            $where .= "AND name like '%".$_GET["q"]."%' ";
        }
        if(isset($_GET["dosyaCategory"]) && $_GET["dosyaCategory"]!="" && $_GET["dosyaCategory"]!="0"){
             $where .= "AND category='".$_GET["dosyaCategory"]."' ";
        }
        $query  = "SELECT sd.*, dc.name AS categoryName, u.adsoyad FROM site_download AS sd ";
        $query .= "LEFT JOIN site_download_category AS dc ON(dc.id=sd.category) ";
        $query .= "LEFT JOIN site_users AS u ON(u.id=sd.user_id) ";
        $query .= "WHERE 1=1 ".$where;
        if(isset($_GET["s"]) && $_GET["s"]!=""){
           $limit = "LIMIT ".$_GET["s"].",".$this->config->item("ilan_rowperpage")." ";
        } else {
           $limit = "LIMIT 0,".$this->config->item("ilan_rowperpage")." ";
        }
        $order  = "ORDER BY savedate DESC ";
        $query.$order.$limit;
        $select = $this->db->query($query.$order);
        $this->total_rows = $select->num_rows();
        $select2 = $this->db->query($query.$order.$limit);
        return $select2->result();
    }
    
    function downloadValues($downloadID){
        $query  = "SELECT * FROM site_download WHERE id='".$downloadID."' ";
        $select = $this->db->query($query);
        return $select->result();
    }


    function dosyaCategoryDropdown($meslekID){
        $query  = "SELECT id, name FROM site_download_category WHERE meslek='".$meslekID."'";
        $select = $this->db->query($query);
        $resultOption = array(
            "0"=>"Tümü"
        );
        if($select->num_rows() > 0){
            $result = $select->result();
            foreach ($result AS $key => $category) {
                $resultOption[$category->id] = "$category->name";
            }
        }
        return $resultOption;
    }
    
    function yukle_save(){
        $category   = addslashes($this->input->post("category"));
        $active     = addslashes($this->input->post("active"));
        $fileUrl    = addslashes($this->input->post("fileUrl"));
        $name       = addslashes($this->input->post("name"));
        $description= addslashes($this->input->post("description"));
        $token      = addslashes($this->input->post("token"));
        $downloadID = addslashes($this->input->post("downloadID"));
        //kontroller
        if(trim($category) != ""){
            if(trim($description) != ""){
                if(trim($active) != ""){
                    if(trim($name) != ""){
                        if(trim($fileUrl) != ""){
                            //kontroller tamam - kayıt başlasın
                            if($downloadID == 0){
                                //insert
                                $query  = "INSERT INTO site_download ";
                                $query .= "VALUES ( ";
                                $query .= "'', ";
                                $query .= "'".$this->session->userdata("user_id")."', ";
                                $query .= "'".$category."', ";
                                $query .= "'".$name."', ";
                                $query .= "'".$description."', ";
                                $query .= "'".$fileUrl."', ";
                                $query .= "NOW(), ";
                                $query .= "'".$active."', ";
                                $query .= "'0' ";
                                $query .= ")";
                                $insert = $this->db->query($query);
                                echo ($this->db->insert_id() > 0) ? '{"success":"true"}' : '{"success":"false"}';
                            }else{
                                //update
                                $query  = "UPDATE site_download ";
                                $query .= "SET ";
                                $query .= "category='".$category."', ";
                                $query .= "user_id='".$this->session->userdata("user_id")."', ";
                                $query .= "name='".$name."', ";
                                $query .= "description='".$description."', ";
                                $query .= "fileurl='".$fileUrl."', ";
                                $query .= "active='".$active."' ";
                                $query .= "WHERE id='".$downloadID."' ";
                                $update = $this->db->query($query);
                                echo '{"success":"true"}';
                            }
                            
                        }else{
                            //token girmedi
                            echo '{"success":"false"}';
                        }
                    }else{
                        //isim girmedi
                        echo '{"success":"false"}';
                    }
                }else{
                    //ilanid yok girmedi
                    echo '{"success":"false"}';
                }
            }else{
                //detaylarını girmedi
                echo '{"success":"false"}';
            }            
        }else{
            //kategori girmedi
            echo '{"success":"false"}';
        }
    }
}
?>