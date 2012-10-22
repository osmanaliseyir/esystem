<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<script type="text/javascript">
   
   function formSubmit(){
      if( $("#name").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Kategori İsmi Giriniz!") ?>"));   
         return false;
      }
        
      if( $("#description").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Kategori Açıklaması Giriniz!") ?>"));   
         return false;
      }
      
      if( $("#parent").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Kategori Üst Menüsü Giriniz!") ?>"));   
         return false;
      }
        
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/haberler/kategoriler/editsave/<?php echo $data->id . "?token=" . setToken($data->id) ?>',
         data: $("#categoryForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Haber Kategorisi Başarıyla Kaydedildi.") ?> "));
               setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/haberler/kategoriler'",2000);
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Haber Kategori Kaydı Yapılamadı!") ?>"));
            }
         }
      });  
   }
   
</script>
<div id="leftPanel">
   <? require APPPATH."blocks/admin_yetki.php";?>
</div>
<div id="rightPanel">
   <div class="block">
      <div class="head"><?= lang("Kategori Düzenle") ?></div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "categoryForm", "id" => "categoryForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td><?php echo lang("Kategori İsmi", "name") ?></td>
               <td><?php echo form_input(array("name" => "name", "id" => "name","value"=>$data->name, "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Kategori Açıklaması", "description") ?></td>
               <td><?php echo form_textarea(array("name" => "description", "id" => "description","value"=>$data->description, "style" => "height:100px; width:200px;")) ?></td>
            </tr>
            <tr>
               <td colspan="2">
                  <?php echo form_button(array("name" => "kaydet", "content" => lang("Kaydet"), "class" => "blue", "onclick" => "formSubmit()", "style" => "width:130px;")) ?>
                  <?php echo form_button(array("name" => "vazgec", "content" => lang("Vazgeç"), "class" => "grey", "style" => "width:75px;")) ?>            
               </td>
            </tr>
         </table>
      </div>
   </div>
</div>

<div style="display:none" title="<?php echo lang("Üst Menü Seç") ?>" id="parentDialog">
   <div id="tree"></div>
</div>