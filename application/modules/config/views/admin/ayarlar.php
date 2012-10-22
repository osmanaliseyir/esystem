<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div id="leftPanel">
<? require APPPATH . "modules/config/widgets/configWidget.php" ?>
</div>
<div id="centerPanel" style="width:786px;">
   <div class="block">
      <div class="head"><h3><?php echo lang("Ayarlar") ?></h3></div>
      <div style="padding:10px;">
         <div class="item fl">
            <img src="images/config/site.png"/><br/>
            <span><?php echo lang("Site Ayarları") ?></span>
         </div>
         <div class="item fl">
            <img src="images/config/yonetim.png"/><br/>
            <span><?php echo lang("Yönetim Ayarları") ?></span>
         </div>
         <div class="item fl">
            <img src="images/config/kullanici.png"/><br/>
            <span><?php echo lang("Kullanıcı Ayarları") ?></span>
         </div>
      </div>
   </div>
</div>
