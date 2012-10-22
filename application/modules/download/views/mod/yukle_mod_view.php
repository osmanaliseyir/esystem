<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//form helper
$this->load->helper("form");
?>
<!-- SWF Upload için -->
<script type="text/javascript" src="<?php echo base_url() ?>externals/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>externals/swfupload/jquery.swfupload.js"></script>
<!-- JS functions -->
<script type="text/javascript">
    
   function formSubmit(){
      if( $("#category").val()=="0"){
         $("#result").html(resultFormat("warning","<?php echo lang("Kategori Seçmelisiniz!") ?>"));   
         return false;
      }
      if( $("#fileUrl").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Dosya Yüklemelisiniz!") ?>"));   
         return false;
      }
      if( $("#name").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Dosya Adını Giriniz!") ?>"));   
         return false;
      }
      if( $("#description").val()==""){
         $("#result").html(resultFormat("warning","<?php echo lang("Dosya Açıklamasını Giriniz!") ?>"));   
         return false;
      }
      $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/download/yukle_save',
         data: $("#pageForm").serialize(),
         dataType:'json',
         success:function(respond){
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Dosya başarıyla yüklenmiştir.") ?> "));
               setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/download'",1000);
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Dosya Yüklenemedi!") ?>"));
            }
         }
      });  
   }
   
    $(function(){
      $('#swfupload-control').swfupload({
         upload_url: "<? echo base_url() ?>common/downloadDosyaYukle/",
         file_post_name: 'uploadfile',
         file_size_limit : "10000",
         file_types : "*.doc; *.docx; *.xls; *.xlsx; *.ppt; *.pptx; *.rar; *.zip; *.tif; *.psd; *.jpg; *.jpeg; *.bmp; *.gif; *.png; *.pdf",
         file_types_description : "Sakıncasız Dosyalar",
         file_upload_limit : 1,
         flash_url : "<?=base_url()?>externals/swfupload/swfupload.swf",
         button_image_url : '<? echo base_url() ?>externals/swfupload/XPButtonUploadText_61x22.png',
         button_width : 61,
         button_height : 22,
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
         $('#queuestatus').text('<?=lang("Seçilen Dosyalar")?> : '+numFilesSelected+' / <?=lang("İşlenen Dosyalar")?>: '+numFilesQueued);
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
                $("#fileUrl").val(data.imageurl);
                $("#fileList").html("<img src='<?=base_url()?>public/downloads/"+data.imageurl+"'/>");
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
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">

    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() . url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/download">Download</a></li>
            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/download">Yönetim</a></li>
            <li>Dosya Yükle</li>
        </ul>
    </div>
    
    
    <!-- ################################## -->
    
    
    
   <div class="block">
      <div class="head"> Dosya Yükle </div>
      <div style="padding:10px;">
         <?php echo form_open("", array("name" => "pageForm", "id" => "pageForm")) ?>
         <?php echo form_input(array("type" => "hidden", "name" => "downloadID", "id" => "downloadID", "value" => ((isset($downloadValues))?($downloadValues[0]->id):("0")), "style" => "width:450px;")) ?>
         <?php echo form_input(array("type" => "hidden", "name" => "token", "id" => "token", "value" => ((isset($downloadValues))?(setToken($downloadValues[0]->id."download")):("")), "style" => "width:450px;")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td width="20%"><?php echo lang("Dosya Kategorisi", "category") ?></td>
               <td><?php echo form_dropdown("category", $dosyaCategoryDropdown, ((isset($downloadValues))?($downloadValues[0]->category):("")), "id='category' style='width:200px;'") ?></td>
            </tr>
            <tr>
               <td ><?php echo lang("Dosya Durumu", "active", lang("Durumu pasif olanlar görüntülenmeyecektir.")) ?></td>
               <td><?php echo form_dropdown("active", array("1" => lang("Aktif"), "0" => lang("Pasif")),((isset($downloadValues))?($downloadValues[0]->active):("")), "id='active' style='width:200px;'") ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Dosya Seç","label")?></td>
                <td>
                    <?
                    if(isset($downloadValues)){
                    ?>
                        <div><?=$downloadValues[0]->fileurl?></div>
                    <?
                    }
                    ?>
                    <div style="width:280px; float:left;">
                        <input value="<?=((isset($downloadValues))?($downloadValues[0]->category):(""))?>" type="hidden" name="fileUrl" id="fileUrl" />
                        <div id="swfupload-control">
                            <input type="button" id="button" />
                            <p id="queuestatus" ></p>
                            <ul id="log"></ul>
                        </div>
                    </div>
                    <div style="float:left; width:200px; padding:10px;">
                        <div id="fileList"></div>
                        <div id="fileResult"></div>
                    </div>
                </td>
            </tr>
            <tr>
               <td><?php echo lang("Dosya Adı", "name") ?></td>
               <td><?php echo form_input(array("name" => "name", "id" => "name", "value" => ((isset($downloadValues))?($downloadValues[0]->name):("")), "style" => "width:450px;")) ?></td>
            </tr>
            <tr>
               <td valign="top"><?php echo lang("Dosya Açıklaması", "description") ?></td>
               <td><?php echo form_textarea(array("name" => "description", "id" => "description", "value" => ((isset($downloadValues))?($downloadValues[0]->description):("")), "style" => "height:75px; width:450px;")) ?></td>
            </tr>
            <tr>
               <td></td>
               <td>
                  <?php echo form_button(array("name" => "kaydet", "content" => lang("Kaydet"), "class" => "blue", "onclick" => "formSubmit()", "style" => "width:130px;")) ?>
                  <?php echo form_button(array("name" => "vazgec", "content" => lang("Vazgeç"), "class" => "grey", "onclick" => "window.location.href='".base_url().url_title($this->meslekname)."/admin/download'", "style" => "width:75px;")) ?>            
               </td>
            </tr>
         </table>
      </div>
   </div>
    
    
    <!-- ################################## -->
    
    
    
</div>



