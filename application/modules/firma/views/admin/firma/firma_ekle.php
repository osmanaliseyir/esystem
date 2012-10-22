<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-treeview/jquery.treeview.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-treeview/jquery.treeview.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>externals/masked-input.js"></script>

<script type="text/javascript">
   
   $(function(){
      $("#sabittel").mask("(999) 999 99 99");
      $("#ceptel").mask("(999) 999 99 99");
      $("#faks").mask("(999) 999 99 99");
   });
   
   function getIlces(id){
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>account/getIlcesJson',
            data: 'id='+id,
            dataType:'json',
            success:function(respond){  
                if(respond.success=="true"){
                    $("#ilce").html("");
                    var html="";
                    $.each(respond.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.ad+"</option>";
                    });
                    $("#ilce").html(html);
                }else if (respond.success=="false") {
                }
            }
        }); 
    }
   
   function pickParent(){
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/firma/category/parents/',
         dataType:'json',
         success:function(respond){
            if(respond){
               var data=respond.data;
               var html="<ul id='treeMenu' class='filetree'>";
               html+=menuCreate(data);
               html+="</ul>";
               $("#tree").html(html);
               $("#tree").treeview({ collapsed:true});
            }
         }
      });  
      $("#parentDialog").dialog({
      width:400,
      height:300,
      modal:true
      });
      
   } 

   function menuCreate(data){
      var html="";
      $.each(data,function(key,value){
         html+="<li><span class='"+value.cls+"'><a href='javascript:void(0)' onclick='selectParent(\""+value.id+"\",\""+value.name+"\")'>"+value.name+"</a></span>";
         if(value.menu){
            html+="<ul>"; 
            html+=menuCreate(value.menu); 
            html+="</ul>"; 
         }
         html+="</li>";
      });
      return html;
   }

   function selectParent(id,name){
      $("#parentDialog").dialog('close');
      $("#categoryname").html(name);
      $("#category").val(id);
   }
     
   $(function(){
      $("#description").cleditor({ width:550, height:200});
   });  
   function formSubmit(){
      if( $("#name").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Firma İsmi Giriniz!") ?>"));   
         return false;
      }
        
      if( $("#description").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Firma Açıklaması Giriniz!") ?>"));   
         return false;
      }
      
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/firma/firmalar/save',
         data: $("#pageForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Firma Başarıyla Eklenmiştir.") ?> "));
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Firma Düzenlenemedi!") ?>"));
            }
         }
      });  
   }
   
</script>
<div id="leftPanel">
   <div class="block">
      <div class="head"><h3><?= lang("Firma İşlemleri") ?></h3></div>
      <ul class="listMenu">
         <li><a href="<?php echo base_url() ?>admin/firma/firmalar"><?php echo lang("Firmalar") ?></a></li>
      </ul>
   </div>
</div>
<div id="centerPanel" style="width:786px;">
   <div class="block">
      <div class="head"><h3><?= lang("Firma Ekle") ?></h3></div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "pageForm", "id" => "pageForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Firma Kategorisi", "category") ?></td>
               <td>
                  <span id="categoryname"></span> 
                  <input type="hidden" id="category" name="category" value=""/>
                  <a href="javascript:void(0)" onclick="pickParent()"><?php echo lang("Seç") ?></a>
               </td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Firma İli", "il") ?></td>
               <td><?php echo form_dropdown("il", $ils, "", "id='il' style='width:200px;' onchange='getIlces(this.value)'") ?></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Firma İlçesi", "ilce") ?></td>
               <td><?php echo form_dropdown("ilce", $ilces, "", "id='ilce' style='width:200px;' ") ?></td>
            </tr>
            <tr>
               <td ><?php echo lang("Firma Durumu", "active", lang("Durumu pasif olanlar görüntülenmeyecektir.")) ?></td>
               <td><?php echo form_dropdown("active", array("1" => lang("Aktif"), "0" => lang("Pasif")), "", "id='active' style='width:200px;'") ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma İsmi", "name") ?></td>
               <td><?php echo form_input(array("name" => "name", "id" => "name", "value" => "", "style" => "width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Yetkilisi", "email") ?></td>
               <td><?php echo form_input(array("name" => "adsoyad", "id" => "adsoyad", "value" => "", "style" => "width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Sabit Tel", "sabittel") ?></td>
               <td><?php echo form_input(array("name" => "sabittel", "id" => "sabittel", "value" => "", "style" => "width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Cep Tel", "ceptel") ?></td>
               <td><?php echo form_input(array("name" => "ceptel", "id" => "ceptel", "value" => "", "style" => "width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Faks", "faks") ?></td>
               <td><?php echo form_input(array("name" => "faks", "id" => "faks", "value" => "", "style" => "width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma E-Posta Adresi", "email") ?></td>
               <td><?php echo form_input(array("name" => "email", "id" => "email", "value" => "", "style" => "width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Adresi", "adres") ?></td>
               <td><?php echo form_textarea(array("name" => "adres", "id" => "adres", "value" => "", "style" => "height:100px; width:300px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firma Açıklaması", "description") ?></td>
               <td><?php echo form_textarea(array("name" => "description", "id" => "description", "value" => "", "style" => "height:200px; width:750px;")) ?></td>
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
<div style="display:none" title="<?php echo lang("Üst Menü Seç") ?>" id="parentDialog">
   <div id="tree"></div>
</div>