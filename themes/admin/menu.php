<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
?>
<div id="menu">
   <ul id="qm0" class="qmmc">
      <li><a class="qmparent" href="<?= base_url() ?>admin/dashboard"><img alt="<?php echo lang("Anasayfa") ?>" src="images/home.png"></a></li>
      <li><a class="qmparent" href="<?= base_url() ?>admin/account"><?php echo lang("Profilim") ?></a></li>
      <li><a class="qmparent" href="<?= base_url() ?>admin/config"><?php echo lang("Ayarlar") ?></a>
         <ul>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/site"><?php echo lang("Site Ayarları") ?></a></li>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/yonetim"><?php echo lang("Yönetim Ayarları") ?></a></li>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/user"><?php echo lang("Kullanıcı Ayarları") ?></a></li>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/contact"><?php echo lang("İletişim Ayarları") ?></a></li>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/firma"><?php echo lang("Firma Ayarları") ?></a></li>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/ilan"><?php echo lang("İlan Ayarları") ?></a></li>
            <li><a class="qmparent" href="<?= base_url() ?>admin/config/haber"><?php echo lang("Haber Ayarları") ?></a></li>
         </ul>
      </li> 
      <li><a class="qmparent" href="<?= base_url() ?>admin/users"><?php echo lang("Kullanıcılar") ?></a></li>
      <li><a class="qmparent" href="<?= base_url() ?>admin/pages"><?php echo lang("Sayfalar") ?></a></li>
      <li><a class="qmparent" href="javascript:void(0)">Forumlar</a>
          <ul>
             <li><a class="qmparent" href="<?=base_url()?>admin/forum/forumlar">Forumlar</a></li>  
          </ul>
      </li>
      <li><a class="qmparent" href="javascript:void(0)">Haberler</a>
          <ul>
             <li><a class="qmparent" href="<?=base_url()?>admin/haber/haberler">Haberler</a></li>  
             <li><a class="qmparent" href="<?=base_url()?>admin/haber/category">Haber Kategorileri</a></li>  
          </ul>
      </li>
   </ul>
</div>
<div style="clear: both"></div>

<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click (options: 'all' * 'all-always-open' * 'main' * 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false,false);</script>

<div id="submenu">

</div>
