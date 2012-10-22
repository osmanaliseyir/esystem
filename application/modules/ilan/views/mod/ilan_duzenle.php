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
    
    function kaydet(ilanID, token){
        if($("#name").val() == ""){
            $("#result").html(resultFormat('warning','İlan Başlığını Girmelisiniz!'));
            return false;
        }
        if($("#description").val() == ""){
            $("#result").html(resultFormat('warning','İlan Açıklamasını Girmelisiniz!'));
            return false;
        }
        $("#result").html(resultFormat('pending','İlanınız Kaydediliyor...'));
        $.ajax({
            url     : '<?= base_url() ?>'+'<?=url_title($this->meslekname)?>'+'/admin/ilanlar/editsavedenKaydet',
            type    : 'post',
            data    : 'ilanID='+ilanID+'&token='+token+'&'+$("#ilanForm").serialize(),
            dataType: "json",
            success : function(respond){
                if(respond.success=="true"){
                    $("#result").html(resultFormat("success","<?= lang("İlan Başarıyla kaydedilmiştir.") ?>"));   
                    setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/ilanlar'",2000);
                } else {
                    $("#result").html(resultFormat("alert","<?= lang("Hata : İlan Kaydedilemedi.") ?>"));   
                }
            }
        });
        
    }
</script>
<div id="leftPanel">
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">
    <div class="itemTitle" style="margin-top:10px;">İlan Düzenle</div>
    <div class="fix"></div>
    <div>
        <div id="result"></div>
        <? echo form_open("",array("id"=>"ilanForm","name"=>"ilanForm")); ?>
        <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
                <td width="20%"><label for="name">İlan Kategorisi</label></td>
                <td><? echo form_dropdown("category",$categories, $data->category) ?></td>
            </tr>
            <tr>
                <td><label for="name">İlan Başlığı</label></td>
                <td><? echo form_input(array("id"=>"name","name"=>"name","style"=>"width:540px;","value"=>$data->name)) ?></td>
            </tr>
            <tr>
                <td><label for="name">İlan İli</label></td>
                <td><?php echo form_dropdown("il", $iller, $data->il, "id='il' onchange='getIlces(this.value)'") ?></td>
            </tr>
            <tr>
                <td><label for="name">İlan İlçesi</label></td>
                <td><?php echo form_dropdown("ilce", $ilceler, $data->ilce, "id='ilce'") ?> <div id="ilceResult" style="float:right; width:200px;"></div></td>
            </tr>
            <tr>
                 <td><label for="active">İlan Durumu</label></td>
                 <td><input type="radio" name="active" value="1" <?= ($data->active == 1) ? "checked=checked" : "" ?>/>Aktif &nbsp;<input type="radio" name="active" <?= ($data->active == 0) ? "checked=checked" : "" ?> value="0"/>Pasif  </td>
            </tr>
             <tr>
                <td valign="top"><label for="description">İlan Açıklaması</label></td>
                <td><? echo form_textarea(array("id"=>"description","name"=>"description","style"=>"width:540px; height:200px;","value"=>$data->description)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?=form_button(array("onclick"=>"kaydet(".$data->id.", '".setToken($data->id."ilan")."');", "content"=>"<img src='images/icons/tick.png' /> Kaydet")) ?></td>
            </tr>
            
        </table>
        <? echo form_close(); ?>
    </div>
</div>
