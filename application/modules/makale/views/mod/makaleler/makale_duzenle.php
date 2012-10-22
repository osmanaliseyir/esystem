<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
$this->load->helper("form");
?>
<script type="text/javascript" src="<?php echo base_url() ?>externals/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>externals/swfupload/jquery.swfupload.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-treeview/jquery.treeview.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-treeview/jquery.treeview.js"></script>
<script type="text/javascript">
    
   
  
   
   $(function(){
      $("#description").cleditor({ width:630, height:400});
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
      
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/makaleler/editsave/<?php echo $data->id . "?token=" . setToken($data->id) ?>',
         data: $("#pageForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Makale Başarıyla Düzenlendi.") ?> "));
               setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/makaleler'",2000);

            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Makale Düzenlenemedi!") ?>"));
            }
         }
      });  
   }
   
     $(function(){
      $('#swfupload-control').swfupload({
         upload_url: "<? echo base_url()?>common/makaleImage/",
         file_post_name: 'uploadfile',
         file_size_limit : "6000",
         file_types : "*.jpg;*.png;*.gif",
         file_types_description : "Image files",
         file_upload_limit : 1,
         flash_url : "<?=base_url()?>externals/swfupload/swfupload.swf",
         button_image_url : '<? echo base_url() ?>externals/swfupload/wdp_buttons_upload_114x29.png',
         button_width : 114,
         button_height : 29,
         button_placeholder : $('#button')[0],
         debug: false
      })
      .bind('fileQueued', function(event, file){
         var listitem='<li id="'+file.id+'" >'+
            'Dosya: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
            '<div class="progressbar" ><div class="progress" ></div></div>'+
            '<p class="status" ><?=lang("Bekliyor")?></p>'+
            '<span class="cancel" >&nbsp;</span>'+
            '</li>';
         $('#log').append(listitem);
         $('li#'+file.id+' .cancel').bind('click', function(){
            var swfu = $.swfupload.getInstance('#swfupload-control');
            swfu.cancelUpload(file.id);
            $('li#'+file.id).slideUp('fast');
         });
         // start the upload since it's queued
         $(this).swfupload('startUpload');
      })
      .bind('fileQueueError', function(event, file, errorCode, message){
         alert('Sadece 1 adet dosya seçebilirsiniz');
      })
      .bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
      })
      .bind('uploadStart', function(event, file){
         $('#log li#'+file.id).find('p.status').text('<?=lang("Yükleniyor..")?>');
         $('#log li#'+file.id).find('span.progressvalue').text('0%');
         $('#log li#'+file.id).find('span.cancel').hide();
      })
      .bind('uploadProgress', function(event, file, bytesLoaded){
         //Show Progress
         var percentage=Math.round((bytesLoaded/file.size)*100);
         $('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
         $('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
      })
      .bind('uploadSuccess', function(event, file, serverData){
         var item=$('#log li#'+file.id);
            var data=JSON.parse(serverData);
            if(data.success=="false"){
                item.find('div.progress').css('width', '0');
                item.find('span.progressvalue').text('0%');
                item.addClass('error').find('p.status').html(data.msg);
            } else {
                $("#imageurl").val(data.imageurl);
                $("#photoList").html("<img src='<?=base_url()?>public/images/makale/"+data.imageurl+"'/>");
                item.find('div.progress').css('width', '100%');
                item.find('span.progressvalue').text('100%');
                item.addClass('success').find('p.status').html('<?= lang("Bitti!") ?> | '+data.msg);
            }
       
      })
      .bind('uploadComplete', function(event, file){
         // upload has completed, try the next one in the queue
         $(this).swfupload('startUpload');
      })
	
   });
   
</script>
<div id="leftPanel">
   <? require APPPATH."blocks/admin_yetki.php"; ?>
</div>
<div id="rightPanel" >
   <div class="block">
      <div class="head"><?= lang("Makale Düzenle") ?></div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "pageForm", "id" => "pageForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Makale Kategorisi", "category") ?></td>
               <td><?php echo form_dropdown("category", $categories, $data->category, "id='category' style='width:200px;'") ?></td>

            </tr>
            <tr>
               <td ><?php echo lang("Makale Durumu", "active", lang("Durumu pasif olanlar görüntülenmeyecektir.")) ?></td>
               <td><?php echo form_dropdown("active", array("1" => lang("Aktif"), "0" => lang("Pasif")), $data->active, "id='active' style='width:200px;'") ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Makale Resmi","label")?></td>
                <td>
                    <div style="width:280px; float:left;">
                       <input type="hidden" name="imageurl" id="imageurl" value="<?=$data->image?>"/>
                                
                   
                        <div id="swfupload-control">
                                 <input type="button" id="button" />
                                 <span class="smalldesc" style="display:block; padding-top:10px;"><? echo lang("Resmi Değiştirmek için upload butonuna basarak yeni bir resim seçebilirsiniz..") ?></span>
                                 <p id="queuestatus" ></p>
                                 <ul id="log"></ul>
                              </div> 
                    </div>
                    <div style="float:left; width:200px; padding:10px;">
                        <div id="photoList"><? 
                        if($data->image!="" && file_exists("public/images/makale/".$data->image."")){
                            echo "<img width='172' src='".base_url()."public/images/makale/".$data->image."'/>";
                        } else {
                            echo lang("Makaleye Resim Yüklenmemiştir.");
                        }
                        ?></div>
                        <div id="photoResult"></div>
                    </div>
                   
                            
                        
                    </div>
                </div></td>
            </tr>
            <tr>
               <td><?php echo lang("Makale Başlığı", "name") ?></td>
               <td><?php echo form_input(array("name" => "name", "id" => "name", "value" => $data->name, "style" => "width:450px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Makale Alt Başlığı", "subtitle") ?></td>
               <td><?php echo form_textarea(array("name" => "subtitle", "id" => "subtitle", "value" => $data->subtitle, "style" => "height:100px; width:450px;")) ?></td>
            </tr>
            <tr>
               <td colspan="2"><?php echo form_textarea(array("name" => "description", "id" => "description", "value" => $data->description, "style" => "height:400px; width:350px;")) ?></td>
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