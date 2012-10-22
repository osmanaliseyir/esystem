<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<link rel="stylesheet" href="<?= base_url() ?>externals/jquery-passwordchecker/passwordchecker.css"/>
<script type="text/javascript" src="<?= base_url() ?>externals/jquery-passwordchecker/jquery.pstrength-min.1.2.js"></script>
<script type="text/javascript">
    $(function(){
        $("#newpass").pstrength(); 
    });

    function formSubmit(){
        if($("#oldpass").val()==""){
            $("#result").html(resultFormat("warning","Eski Şifrenizi Giriniz!"));
            return false;
        }
        if($("#newspass").val()==""){
            $("#result").html(resultFormat("warning","Yeni Şifrenizi Giriniz!"));
            return false;
        }
        if($("#newpass2").val()==""){
            $("#result").html(resultFormat("warning","Yeni Şifrenizi Tekrar Giriniz!"));
            return false;
        }
        if($("#newpass2").val()!=$("#newpass").val()){
            $("#result").html(resultFormat("warning","Yeni girmiş Olduğunuz şifreler birbiri ile uyuşmuyor!"));
            return false;
        }
        if($("#newpass").val().length<4){
            $("#result").html(resultFormat("warning","Yeni Şifreniz En az 4 karakterli olmalı!"));
            return false;
        }
        
        $("#result").html(resultFormat("pending","Şifreniz Değiştiriliyor..."));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>sifre-kontrol',
            data: $("#passForm").serialize(),
            dataType:'json',
            success:function(respond){  
                if(respond.success=="true"){
                    $("#result").html(resultFormat("success",""+respond.msg+""));
                    document.getElementById("passForm").reset();
                    
                }else if (respond.success=="false") {
                    $("#result").html(resultFormat("alert",respond.msg));
                }
            }
        }); 

        
        
    }

</script>
<div id="leftPanel">
    <? require APPPATH . 'blocks/profilim.php'; ?>
</div>
<div id="rightPanel">

    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li>Şifremi Değiştir</li>
        </ul>
    </div>
    <div class="fix"></div>

    <div class="itemTitle" style="margin-top:10px;">Şifre Değişikliği</div>
    
    <?php echo form_open("", array("id" => "passForm", "name" => "passForm")) ?>
    <table class="formTable" cellpadding="6" cellspacing="0">
        <tr>
            <td colspan="2"><span class="smalldesc">Güvenliğiniz için eski şifrenizi girmeniz gerekmektedir. 
                    Şifrenizin daha güvenilir olması için Büyük harf, küçük harf, sembol ve rakam içeren şifreler oluşturunuz.</span>
                <div id="result" style="margin-top:10px;margin-bottom:10px;"></div></td>
        </tr>
        <tr>
            <td width="30%"><?php echo lang("Şuanki Şifreniz", "oldpass", "Şuanki Şifreniz") ?></td>
            <td><?php echo form_input(array("type" => "password", "id" => "oldpass", "name" => "oldpass", "style" => "width:200px;")) ?></td>
        </tr>
        <tr>
            <td><?php echo lang("Yeni Şifreniz", "newpass", "Yeni Şifreniz") ?></td>
            <td><?php echo form_input(array("type" => "password", "id" => "newpass", "name" => "newpass", "style" => "width:200px;")) ?></td>
        </tr>
        <tr>
            <td><?php echo lang("Yeni Şifreniz (Tekrar)", "newpass2", "Yeni Şifreniz Tekrar") ?></td>
            <td><?php echo form_input(array("type" => "password", "id" => "newpass2", "name" => "newpass2", "style" => "width:200px;")) ?>
                <div class="pstrength-minchar">En az 4 Karakter giriniz!</div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><a href="javascript:void(0)" class="btn btnRed btnSmall" onclick="formSubmit()">Şifremi Değiştir</a></td>
        </tr>
    </table>
    <? echo form_close(); ?>

</div>
