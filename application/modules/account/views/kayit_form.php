<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper("form");
?>
<div id="leftPanel">
    <?php
    //İlan Kategorileri
    require APPPATH . 'blocks/ilan_kategorileri.php';

    //Firma Kategorileri
    require APPPATH . 'blocks/firma_kategorileri.php';
    ?>
</div>
<div id="centerPanel">
    <?
    //Üyelik ikisi birden
    require APPPATH . 'blocks/uyelik_ikisi.php';
    
    //Son İlanlar
    require APPPATH . 'blocks/son_isveren_ilanlar.php';
    
    ?>
</div>
<div id="rightPanel">
    <?php echo openBlock(lang("Üye İseniz")) ?>
    <div style="padding:10px">
        <?php echo lang("Sitemize üye iseniz e-posta adresiniz ve şifreniz ile giriş yapabilirsiniz"); ?>
        <div style="margin-top:6px;" align="center">
            <?php echo form_button(array("content" => lang("Üye Girişi"), "class" => "blue", "style" => "width:180px;", "onclick" => "window.location='" . base_url() . "login'")); ?>
        </div>
    </div>
    <?php echo closeBlock(); ?>
    
    <?php echo openBlock(lang("Şifremi Unuttum")) ?>
    <div style="padding:10px">
        <?php echo lang("Şifrenizi mi unuttuysanız E-posta adresinize yeni bir şifre gönderip eski şifrenizi sıfırlıyoruz.."); ?><br/>
        <span class="smalldesc"><?php echo lang("Tek Yapmanız gereken şifremi unuttum bölümünden e-posta adresinize yeni bir şifre istemek") ?></span>
        <div style="margin-top:6px;" align="center">
            <?php echo form_button(array("content" => lang("Şifremi Unuttum"), "class" => "blue", "style" => "width:120px;", "onclick" => "window.location='" . base_url() . "account/forgotpassword'")); ?>
        </div>
    </div>
    <?php echo closeBlock(); ?>
    
    <?
    //Dil Seçimi
    require APPPATH . 'blocks/diller.php';
    ?>
</div>
