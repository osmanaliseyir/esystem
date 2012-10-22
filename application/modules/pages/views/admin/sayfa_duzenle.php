<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<script type="text/javascript">
     
   $(function(){
      $("#description").cleditor({ width:750, height:400});
   });  
   function formSubmit(){
      if( $("#name").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Sayfa İsmi Giriniz!") ?>"));   
         return false;
      }
        
      if( $("#description").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Sayfa Açıklaması Giriniz!") ?>"));   
         return false;
      }
      
      if( $("#type").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Sayfa Tipini Giriniz!") ?>"));   
         return false;
      }
      
      if( $("#lang").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Sayfa Dilini Giriniz!") ?>"));   
         return false;
      }
        
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/pages/editsave/<?php echo $data->id . "?token=" . setToken($data->id) ?>',
         data: $("#pageForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Sayfanız Başarıyla Düzenlendi.") ?> "));
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Sayfa Düzenlenemedi!") ?>"));
            }
         }
      });  
   }
   
</script>
<div id="leftPanel">
   <div class="block">
      <div class="head"><h3><?= lang("Sayfa İşlemleri") ?></h3></div>
      <ul class="listMenu">
         <li><a href="<?php echo base_url() ?>admin/pages/add"><?php echo lang("Yeni Sayfa ekle") ?></a></li>
         <li><a href="<?php echo base_url() ?>admin/pages"><?php echo lang("Sayfalar") ?></a></li>
      </ul>
   </div>
</div>
<div id="centerPanel" style="width:786px;">
   <div class="block">
      <div class="head"><h3><?= lang("Sayfa Düzenle") ?></h3></div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "pageForm", "id" => "pageForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Sayfa Dili", "lang") ?></td>
               <td><?php echo form_dropdown("lang", $langs, $data->lang, "id='lang' style='width:200px;'") ?></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Saya Tipi", "type") ?></td>
               <td><?php echo form_dropdown("type", array("1" => "Anasayfa Sayfası","2"=>"Manuel Sayfa"), $data->type, "id='type' style='width:200px;'") ?></td>
            </tr>
            <tr>
               <td ><?php echo lang("Sayfa Durumu", "active", lang("Sayfa Durumu pasif olanlar görüntülenmeyecektir.")) ?></td>
               <td><?php echo form_dropdown("active", array("1" => lang("Aktif"), "0" => lang("Pasif")), $data->active, "id='active' style='width:200px;'") ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Sayfa İsmi", "name") ?></td>
               <td><?php echo form_input(array("name" => "name", "id" => "name", "value" => $data->name, "style" => "width:600px;")) ?></td>
            </tr>
             <tr>
               <td><?php echo lang("Sayfa Adres İsmi", "urlname",lang("Eğer başka bir sayfaya eklemeyecekseniz boş bırakın..")) ?></td>
               <td><?php echo form_input(array("name" => "urlname", "id" => "urlname", "style" => "width:200px;", "value" => $data->urlname)) ?></td>
            </tr>
            <tr>
               <td colspan="2"><?php echo form_textarea(array("name" => "description", "id" => "description", "value" => $data->description, "style" => "height:750px; width:600px;")) ?></td>
            </tr>
            <tr>
               <td></td>
               <td>
                  <?php echo form_button(array("name" => "kaydet", "content" => lang("Kaydet"), "class" => "blue", "onclick" => "formSubmit()", "style" => "width:130px;")) ?>
                  <?php echo form_button(array("name" => "vazgec", "content" => lang("Vazgeç"), "class" => "grey", "style" => "width:75px;")) ?>            
               </td>
            </tr>
         </table>
      </div>
   </div>
</div>
