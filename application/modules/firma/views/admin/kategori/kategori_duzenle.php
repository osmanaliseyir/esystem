<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-treeview/jquery.treeview.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-treeview/jquery.treeview.js"></script>
<script type="text/javascript">
    
    
function selectIcon(name){
   $("#iconDialog").dialog('close');
   $("#iconValue").html("<img src='<?=base_url()?>public/images/icons/"+name+"'>");
   $("#icon").val(name);
}
     function pickIcon(){
   
   $("#iconDialog").dialog();
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
               html+="<li><span class='folder'><a href='javascript:void(0)' onclick='selectParent(\"0\",\"Ana Menü\")'>Ana Menü</a></span>";
               html+="<ul>";
               html+=menuCreate(data);
               html+="</ul>";
               html+="</li>";
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
      $("#parentValue").html(name);
      $("#parent").val(id);
   }
    
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
         url:'<?php echo base_url() ?>admin/firma/category/editsave/<?php echo $data->id . "?token=" . setToken($data->id) ?>',
         data: $("#categoryForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Firma Kategorisi Başarıyla Kaydedildi.") ?> "));
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Firma Kategori Kaydı Yapılamadı!") ?>"));
            }
         }
      });  
   }
   
</script>
<div id="leftPanel">
   <div class="block">
      <div class="head"><h3><?= lang("Firma Kategori İşlemleri") ?></h3></div>
      <ul class="listMenu">
         <li><a href="<?php echo base_url() ?>admin/firma/category/add"><?php echo lang("Yeni Kategori ekle") ?></a></li>
         <li><a href="<?php echo base_url() ?>admin/firma/category"><?php echo lang("Firma Kategorileri") ?></a></li>
      </ul>
   </div>
</div>
<div id="centerPanel">
   <div class="block">
      <div class="head"><h3><?= lang("Kategori Ekle") ?></h3></div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "categoryForm", "id" => "categoryForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td><?php echo lang("Kategori Üst Menüsü", "name") ?></td>
               <td><a href="javascript:void(0)" onclick="pickParent()"><?php echo lang("Seç") ?></a>
                  <span id="parentValue"><?php echo ($data->parent == 0) ? lang("Ana Kategori") : $data->parentname; ?></span> <input type="hidden" id="parent" name="parent" value="<?php echo $data->parent ?>"/>
               </td>
            </tr>
             <tr>
               <td><?php echo lang("Kategori İkonu", "name") ?></td>
               <td><a href="javascript:void(0)" onclick="pickIcon()"><?php echo lang("Seç") ?></a>
                  <span id="iconValue"><?php echo (isset($data->ord) && $data->ord!="") ? "<img src='".base_url()."public/images/icons/".$data->ord."'/>" : ""; ?></span> <input type="hidden" id="icon" name="icon" value="<?php echo $data->ord ?>"/>
               </td>
            </tr>
            <tr>
               <td><?php echo lang("Kategori İsmi", "name") ?></td>
               <td><?php echo form_input(array("name" => "name", "id" => "name", "value" => $data->name, "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Kategori Açıklaması", "description") ?></td>
               <td><?php echo form_textarea(array("name" => "description", "id" => "description", "value" => $data->description, "style" => "height:100px; width:200px;")) ?></td>
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
<div style="display:none" title="<?php echo lang("İkon Seç") ?>" id="iconDialog">
   <? 
    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir("public/images/icons/");

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

      // if file isn't this directory or its parent, add it to the results
      if ($file != "." && $file != "..") {
       echo "<a href='javascript:void(0)' onclick='selectIcon(\"".$file."\")'><img style='margin:5px;' src='".base_url()."public/images/icons/".$file."'></a>";
      }

    }

    // tidy up: close the handler
    closedir($handler);

   
   ?>
</div>