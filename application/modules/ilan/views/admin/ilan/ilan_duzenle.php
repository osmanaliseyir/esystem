<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-treeview/jquery.treeview.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-treeview/jquery.treeview.js"></script>
<script type="text/javascript">
    
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
         url:'<?php echo base_url() ?>admin/ilan/category/parents/',
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
         $("#result").html(resultFormat("warning","<?php echo lang("İlan İsmi Giriniz!") ?>"));   
         return false;
      }
        
      if( $("#description").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("İlan Açıklaması Giriniz!") ?>"));   
         return false;
      }
      
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/ilan/ilanlar/editsave/<?php echo $data->id . "?token=" . setToken($data->id) ?>',
         data: $("#pageForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("İlan Başarıyla Düzenlendi.") ?> "));
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("İlan Düzenlenemedi!") ?>"));
            }
         }
      });  
   }
   
</script>
<div id="leftPanel">
   <div class="block">
      <div class="head"><h3><?= lang("İlan İşlemleri") ?></h3></div>
      <ul class="listMenu">
         <li><a href="<?php echo base_url() ?>admin/ilan/ilanlar"><?php echo lang("İlanlar") ?></a></li>
      </ul>
   </div>
</div>
<div id="centerPanel" style="width:786px;">
   <div class="block">
      <div class="head"><h3><?= lang("İlan Düzenle") ?></h3></div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "pageForm", "id" => "pageForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("İlan Kategorisi", "category") ?></td>
               <td>
                  <span id="categoryname"> <?php echo ($data->category == 0) ? lang("Ana Kategori") : $data->categoryname; ?></span> 
                  <input type="hidden" id="category" name="category" value="<?php echo $data->category ?>"/>
                  <a href="javascript:void(0)" onclick="pickParent()"><?php echo lang("Değiştir") ?></a>
               </td>
            </tr>
            <tr>
                        <td width="30%"><?php echo lang("İlan İli", "il") ?></td>
                        <td><?php echo form_dropdown("il", $ils, $data->il, "id='il' style='width:200px;' onchange='getIlces(this.value)'") ?></td>
                    </tr>
                    <tr>
                        <td width="30%"><?php echo lang("İlan İlçesi", "ilce") ?></td>
                        <td><?php echo form_dropdown("ilce", $ilces, $data->ilce, "id='ilce' style='width:200px;'") ?></td>
                    </tr>
                    <? 
                    if($data->user_type=="2"){
                        
                    ?>
                    
                    <tr>
                        <td width="200"><?php echo lang("Aradığınız Cinsiyet", "cinsiyet") ?></td>
                        <td><?php echo form_dropdown("cinsiyet", array("0"=>lang("Farketmez"),"1"=>lang("Erkek"),"2"=>lang("Bayan")), $data->cinsiyet, "id='cinsiyet' style='width:200px;'") ?></td>
                    </tr>
                    <tr>
                        <td width="200"><?php echo lang("Aradığınız Yaş Aralığı", "yas") ?></td>
                        <td><?php echo form_dropdown("yas", array("0"=>lang("Farketmez"),"1"=>"18-25","2"=>"25-30","3"=>"30-40","4"=>"40-40+"), $data->yas, "id='yas' style='width:200px;'") ?></td>
                    </tr>
                    
                    <? 
                    }
                    ?>
                    <tr>
                       <td ><?php echo lang("İlan Durumu", "active", lang("Durumu pasif olanlar görüntülenmeyecektir.")) ?></td>
                       <td><?php echo form_dropdown("active", array("1" => lang("Aktif"), "0" => lang("Pasif")), $data->active, "id='active' style='width:200px;'") ?></td>
                    </tr>
                    <tr>
                        <td width="200"><?php echo lang("İlan Başlığı", "name") ?></td>
                        <td><?php echo form_input(array("name" => "name", "id" => "name", "style" => "width:550px;","value"=>$data->name)) ?></td>
                    </tr>
                    <tr>
                        <td><?php echo lang("İlan Açıklaması", "name") ?></td>
                        <td><?php echo form_textarea(array("name" => "description", "id" => "description", "style" => "width:600px; height:100px;","value"=>$data->description)) ?></td>
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