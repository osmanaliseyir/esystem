<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type='text/javascript'>
    function formSubmit(){	
        
        if($("#name").val()==""){
            $("#result").html(resultFormat('warning','Lütfen : Konu Başlığını Giriniz!'))
            return false;
        } 
        if($("#description").val()==""){
            $("#result").html(resultFormat('warning','Lütfen : Konu Açıklamasını Giriniz!'))
            return false;
        }
        
        $("#result").html(resultFormat("pending","Konunuz Kaydediliyor..."));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>forum/forum/saveTopic/<?= $id ?>',
            data:$("#konuForm").serialize(),
            dataType:'json',
            success:function(respond){
                if(respond){
                    if(respond.success=="true"){
                        $("#result").html(resultFormat('success',"Konu Başarıyla Kaydedildi. Yönlendiriliyorsunuz..."));
                        window.location=''+respond.link+'';
                    } else {
                        $("#result").html(resultFormat('alert',''+respond.msg+''));
                    }             
                }
            }
        });
	
    }
</script>
<div id="leftPanel">
     <? require APPPATH.'blocks/forumdan_son_konular.php'; ?>
     <? require APPPATH.'blocks/son_uyeler.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href='<?= base_url() ?>'>Anasayfa</a></li>
             <li><a href='<?= base_url() . url_title($this->session->userdata("user_meslekname")) ?>/forumlar'><?= $this->session->userdata("user_meslekname") ?> Forumlar</a></li>
            <li>Konu Ekle</li>
        </ul>
    </div>

    
    <div class="itemTitle" style="margin-top:10px;">Konu Ekle</div>
    <div class="smalldesc">Forumlarda paylaştığınız konu ve mesajlardaki içerikten, içerik yazan sorumludur.</div>
    
    <?php echo form_open("", array("id" => "konuForm", "name" => "konuForm")) ?>
    <table width="100%" cellpadding="6" cellspacing="0" style="" class='formTable'>
        <tr>
            <td colspan="2"><div id="result"></div></td>
        </tr>
        <tr>
            <td width='20%'><?= lang("Konu Başlığı", "name") ?></td>
            <td><?php echo form_input(array("id" => "name", "name" => "name", "style" => "width:540px;")) ?></td>
        </tr>
         <tr>
             <td colspan="2"><span style="font-size:11px; color:#666666;">Konu Başlığınızı girerken büyük harf kullanmayalım ve imla kurallarına uyalım lütfen..</span></td>
        </tr>
        <tr>
            <td valign='top'><?= lang("Konu İçeriği", "name") ?></td>
            <td><?php echo form_textarea(array("id" => "description", "name" => "description", "style" => "height:200px; width:540px;")) ?></td>
        </tr>
        <tr>
            <td></td>
            <td><a href='javascript:void(0)' onclick='formSubmit()' class='btn btnRed btnSmall'>Kaydet</a></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</div>