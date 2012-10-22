<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("file");

$query= $this->db->query("UPDATE site_download SET downloadnum=downloadnum+1 WHERE id='".$id."' ");

$query = $this->db->query("SELECT fileurl FROM site_download WHERE id='" . $id . "'");
$row = $query->row();
$fileName = $row->fileurl;
$mime = get_mime_by_extension($row->fileurl);
$fileUrl = "public/downloads/" . $row->fileurl;


// Set headers
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: " . $mime . "");
header("Content-Transfer-Encoding: binary");

// Read the file from disk
readfile($fileUrl);
?>