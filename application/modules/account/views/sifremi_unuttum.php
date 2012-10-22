<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<script type="text/javascript">
   
   var pageUrl='<?= base_url() ?>';
   $(function(){
      $(".ttip").tipsy();
 
   });

   function formReset(){
      document.getElementById("passwordForm").reset();
      $("#result").html("");
   }

   function loginSubmit(){
      
      if($("#email").val()==""){
         $("#result").html(resultFormat("warning","<?=lang("E-posta Adresinizi Giriniz!")?>"));
         return false;
      }
      
      $("#result").html(resultFormat("pending","<?=lang("Gönderiliyor...")?>"));   
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>account/forgotPasswordCheck',
         data: $("#passwordForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               document.getElementById("passwordForm").reset();
               $("#result").html(resultFormat("success","<?=lang("Şifreniz Mail Adresinize Gönderildi. Yeni Şifrenizle sitemize giriş yapabilirsiniz")?>"));
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert",respond.msg));
            }
         }
      });  
   }
   
</script>
<div id="leftPanel">
    <?php 
    //İlan Kategorileri
    require APPPATH.'blocks/ilan_kategorileri.php'; 
   
    //Firma Kategorileri
    require APPPATH.'blocks/firma_kategorileri.php'; 
    ?>
</div>
<div id="centerPanel">
   <?php echo openBlock(lang("Şifremi Unuttum"),"grey600") ?>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "passwordForm", "id" => "passwordForm")); ?>
         <table width="100%" cellpadding="2" class="formTable">
            <tr>
               <td>
                  <span class="smalldesc"><?php echo lang("sifre_form_aciklama") ?> <?php echo lang("login_form_aciklama2") ?></span>
                  <div id="result" style="margin-top:5px;"></div>
               </td>
            </tr>
            <tr><td style="border-bottom:0"><?php echo lang("E-Posta Adresiniz", "email", lang("Sisteme Giriş Yapmak için kullandığınız e-posta adresi")) ?><td></tr>
            <tr><td><?php echo form_input(array("id" => "email", "name" => "email", "style" => "width:180px; margin-bottom:4px;")); ?></td></tr>
            <tr>
               <td> 
                  <?php echo form_button(array("name" => "login", "content" => lang("Şifremi Gönder"), "class" => "blue", "style" => "width:135px;"), "", "onclick='loginSubmit()'") ?>
                  <?php echo form_button(array("name" => "resett", "content" => lang("Temizle"), "class" => "grey", "style" => "width:72px;"), "", "onclick='this.form.reset()'") ?>
               </td>
            </tr>
         </table>
         <?php echo form_close() ?>
      </div>
  <?php echo closeBlock("grey600") ?>
    
    <?
    //Dil Seçimi
    require APPPATH.'blocks/uyelik_ikisi.php';
    ?>
</div>
<div id="rightPanel">
  <? 
    //Dil Seçimi
    require APPPATH.'blocks/diller.php'; 
    
    ?>
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
    
    //Firmalar
    require APPPATH.'blocks/son_firmalar.php'; 
   
    ?>
</div>


