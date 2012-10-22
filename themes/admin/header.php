<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
   <head>
      <title><?php echo $this->config->item("site_title")?></title>
      <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
      <meta name="author" content="<?php echo $this->config->item("site_author") ?>">
      <meta name="description" content="<?php echo $this->config->item("site_description") ?>">
      <meta name="keywords" content="<?php echo $this->config->item("site_keywords") ?>">
      
      <base href="<?php echo template_url('admin'); ?>">
      <link type="text/css" rel="stylesheet" href="css/default.css"/>
      
      <!-- MENU -->
      <link type="text/css" rel="stylesheet" href="css/menu.css"/>
      <script type="text/javascript" src="js/menu.js"></script>
      
      <!-- LANGUAGE -->     
      <script type="text/javascript" src="<?php echo base_url().APPPATH ?>language/<?php echo $this->session->userdata["user_lang"] ?>/lang.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>public/js/custom.js"></script>
      
      <!-- JQUERY UI -->
      <script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-ui/jquery-ui.js"></script>
      <link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-ui/jquery-ui.css"/>
      
      <!-- JQUERY TOOLTİP -->
      <script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-placeholder/placeholder.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-tooltip/jquery.tipsy.js"></script>
      <link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-tooltip/tipsy.css"/>
     
   </head>
   <body>
      <div id="header">
         <div id="wrapper">
            <div id="user">
               <img src="images/user/userPic.png"> 
                  <span><?php echo lang("Hoşgeldiniz").", ".$this->session->userdata("admin_adsoyad")."!" ?></span>
            </div>
            <div id="topmenu">
               <ul>
                  <li><a href="<?= base_url() ?>admin/account"><img src="images/topnav/profile.png"><span><?php echo lang("Profilim") ?></span></a></li>
                  <li><a href="<?= base_url() ?>admin/config"><img src="images/topnav/settings.png"><span><?php echo lang("Ayarlar") ?></span></a></li>
                  <li><a href="<?= base_url() ?>admin/logout"><img src="images/topnav/logout.png"><span><?php echo lang("Oturumu Kapat") ?></span></a></li>
               </ul>
            </div>
         </div>
      </div>
