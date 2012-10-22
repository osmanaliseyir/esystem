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
      <div class="head"><h3><?= lang("Firma Ayarları") ?></h3></div>
      <? echo form_open("", array("name" => "configForm", "id" => "configForm")); ?>
      <div style="padding:10px;">
         <table width="100%" class="formTable" cellpadding="4" cellspacing="0">
            <tr>
               <td colspan="3"><div id="result"></div></td>
            </tr>
           <tr>
                    <td><?php echo lang("Firma Listeleme Sayısı","firma_rowperpage",lang("Firma Listeleme Sayısını Belirtir.")) ?></td>
                    <td><?php echo form_input(array("name"=>"firma_rowperpage","value"=>$data["firma_rowperpage"],"id"=>"firma_rowperpage","style"=>"width:200px;")) ?></td>
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
