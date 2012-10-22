<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type="text/javascript">
   
    function getIlces(id){
        $("#ilceResult").html(resultFormat('pending','Yükleniyor'));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>common/getIlcesJson',
         data: 'id='+id,
         dataType:'json',
         success:function(respond){  
            $("#ilceResult").html("");
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
   
   
    function kaydet(){
        if($("#name").val()==""){
         $("#result").html(resultFormat('warning','İlan Başlığını Girmelisiniz!'));
         return false;   
        }
        
        if($("#description").val()==""){
         $("#result").html(resultFormat('warning','İlan Açıklamasını Girmelisiniz!'));
         return false;   
        }
        
        if($("#il").val()==""){
         $("#result").html(resultFormat('warning','İlan ilini Girmelisiniz!'));
         return false;   
        }
        
        if($("#ilce").val()==""){
         $("#result").html(resultFormat('warning','İlan ilçesini Girmelisiniz!'));
         return false;   
        }
        
        $("#result").html(resultFormat('pending','İlanınız Kaydediliyor...'));
        $.ajax({
            url:"<?= base_url() ?><?=url_title($this->meslekname)?>/ilanlar/save",
            type:'post',
            data:$("#ilanForm").serialize(),
            dataType:"json",
            success:function(respond){
                if(respond.success=="true"){
                    document.getElementById("ilanForm").reset();
                    $("#result").html(resultFormat("success","<?= lang("İlanınız Başarıyla Kaydedilmiştir. Onaylanmasının ardından yayına girecektir.") ?>"));   
                } else {
                    $("#result").html(resultFormat("alert","<?= lang("Hata : İlanınız Kaydedilemedi.") ?>"));   
                }
            }
        });
        
    }
    
   
    
</script>
<div id="leftPanel" style="width:200px;" >
    
    <div class="subMenu">
    <ul>
        <li><a href="<?=base_url().url_title($this->meslekname)?>/ilanlar/ilanlarim"><img src="images/icons/tickets.png"/> İlanlarım</a></li>
        <li><a href="<?=base_url().url_title($this->meslekname)?>/ilanlar/ekle"><img src="images/icons/ticket--plus.png"/> Yeni İlan Ekle</a></li>
    </ul>
    </div>
    
    <? require APPPATH."blocks/ilan_kategorileri.php" ?>
</div>
<div id="rightPanel" style="width:760px;">
    <div class="pageTitle">
        <ul>
            <li><a href="<?=base_url()?><?=url_title($this->uri->segment(1))?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?=url_title($this->uri->segment(1))?>/ilanlar">İlanlar</a></li>
            <li>İlan Ekle</li>
        </ul>
    </div>
    
    <div class="itemTitle" style="margin-top:10px;">İlan Ekle</div>
    <div class="fix"></div>
    <div style="">
            <div id="result"></div>
        <? echo form_open("",array("id"=>"ilanForm","name"=>"ilanForm")); ?>
        <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
                <td width="20%"><label for="name">İlan Kategorisi</label></td>
                <td><? echo form_dropdown("category",$categories) ?></td>
            </tr>
            <tr>
                <td><label for="name">İlan Başlığı</label></td>
                <td><? echo form_input(array("id"=>"name","name"=>"name","style"=>"width:540px;")) ?></td>
            </tr>
            
            <tr>
                <td><label for="name">İlan İli</label></td>
                <td><?php echo form_dropdown("il",$iller,"","id='il' onchange='getIlces(this.value)'")?></td>
            </tr>
            <tr>
                <td><label for="name">İlan İlçesi</label></td>
                <td><?php echo form_dropdown("ilce",array(),"","id='ilce'")?> <div id="ilceResult" style="float:right; width:200px;"></div></td>
            </tr>
             <tr>
                <td><label for="iletisimvisible">İletişim Bilgileri</label></td>
                <td><input type="checkbox" name="iletisimvisible" value="1" checked="checked"/> İletişim Bilgilerim İlan Detayında yer alsın.</td>
            </tr>
            <tr>
                <td colspan="2"><? echo form_textarea(array("id"=>"description","name"=>"description","style"=>"width:740px; height:200px;")); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="button" class="button" onclick="return kaydet()">İlanımı Kaydet</button>
                <button class="button" onclick="parent.history.back(); return false;">Vazgeç</button></td>
            </tr>
        </table>
        <? echo form_close(); ?>
    </div>
</div>
