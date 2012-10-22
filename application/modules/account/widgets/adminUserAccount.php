<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper("form");
?>
<div class="block">
   <div class="head">
      <h3><?php echo lang("Hesabım"); ?></h3>
   </div>
   <div style="padding:10px;">
      <img style="float:left; border:1px solid #CCCCCC; padding: 2px; margin:5px;" src="images/user/user.png"/>
      <div style="padding-top:10px;"><?php echo $this->session->userdata["admin_name"] ?><br/>
         <b><?php echo $this->session->userdata("admin_adsoyad") ?></b><br/><br/>
      </div>
      <span class="font11"><?php echo lang("Güvenliğiniz için şifrenizi belirli aralıklarla değiştirmenizi öneririz.. ") ?></span></br><br/>
      <?php echo form_button(array("name"=>"button1","content" => lang("Şifremi Değiştir"), "class" => "blue", "style" => "width:180px;"), "", "onclick='window.location=\"".base_url()."admin/account/cp\"'"); ?>
      <?php echo form_button(array("name"=>"button2","content" => lang("Profilimi Düzenle"), "class" => "blue", "style" => "margin-top:5px;width:180px;"), "", "onclick='window.location=\"".base_url()."admin/account/changeProfile\"'"); ?>
   </div>
   <div class="fix"></div><br/>
</div> 

