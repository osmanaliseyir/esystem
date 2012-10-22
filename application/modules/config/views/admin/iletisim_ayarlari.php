<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

$this->load->helper("form");
?>
<script type="text/javascript">
   function configFormSubmit(){
               
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/config/save',
         data: $("#configForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Ayarlar Başarıyla Kaydedildi.") ?> "));
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("warning","<?php echo lang("Ayarlarda Değişiklik Yapılmadı!") ?>"));
            }
         }
      });  
        
   }
</script>

<div id="leftPanel">
   <? require APPPATH . "modules/config/widgets/configWidget.php" ?>
</div>
<div id="centerPanel">
   <div class="block">
      <div class="head"><h3><?= lang("İletişim Ayarları") ?></h3></div>
      <? echo form_open("", array("name" => "configForm", "id" => "configForm")); ?>
      <div style="padding:10px;">
         <table width="100%" class="formTable" cellpadding="4" cellspacing="0">
            <tr>
               <td colspan="3"><div id="result"></div></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma İsmi","contact_firma_isim") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_isim", "id" => "contact_firma_isim", "style" => "width:200px;", "value" => $data["contact_firma_isim"])) ?></td>
            </tr>
            <tr>
               <td valign="top"><?php echo lang("Firma Açıklaması","contact_firma_aciklama") ?></td>
               <td><?php echo form_textarea(array("name" => "contact_firma_aciklama", "id" => "contact_firma_aciklama", "style" => "width:200px; height:100px;", "value" => $data["contact_firma_aciklama"])) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Sabit Telefonu","contact_firma_sabittel") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_sabittel", "id" => "contact_firma_sabittel", "style" => "width:200px;", "value" => $data["contact_firma_sabittel"])) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Sabit Telefonu 2","contact_firma_sabittel") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_sabittel2", "id" => "contact_firma_sabittel2", "style" => "width:200px;", "value" => $data["contact_firma_sabittel2"])) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Cep Telefonu","contact_firma_ceptel") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_ceptel", "id" => "contact_firma_ceptel", "style" => "width:200px;", "value" => $data["contact_firma_ceptel"])) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Cep Telefonu 2","contact_firma_ceptel2") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_ceptel2", "id" => "contact_firma_ceptel2", "style" => "width:200px;", "value" => $data["contact_firma_ceptel2"])) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Faksı","contact_firma_faks") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_faks", "id" => "contact_firma_faks", "style" => "width:200px;", "value" => $data["contact_firma_faks"])) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma E-posta Adresi","contact_firma_email") ?></td>
               <td><?php echo form_input(array("name" => "contact_firma_email", "id" => "contact_firma_email", "style" => "width:200px;", "value" => $data["contact_firma_email"])) ?></td>
            </tr>
            <tr>
               <td valign="top"><?php echo lang("Firma Adresi","contact_firma_adres") ?></td>
               <td><?php echo form_textarea(array("name" => "contact_firma_adres", "id" => "contact_firma_adres", "style" => "width:200px; height:100px;", "value" => $data["contact_firma_adres"])) ?></td>
            </tr>

            <tr>
               <td></td>
               <td>
                  <?php echo form_button(array("name" => "kaydet", "content" => lang("Ayarları Kaydet"), "class" => "blue", "onclick" => "configFormSubmit()", "style" => "width:130px;")) ?>
                  <?php echo form_button(array("name" => "vazgec", "content" => lang("Vazgeç"), "class" => "grey", "style" => "width:75px;")) ?>            
               </td>
            </tr>
         </table>
         <?php echo form_close() ?>
      </div>
   </div>


</div>
<div id="rightPanel"></div>
