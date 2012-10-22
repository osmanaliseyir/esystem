<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<script type="text/javascript">
    $(function(){
        $('#l-email,#l-password').keypress(function(e){
            if(e.which == 13){
                $('#loginForm').submit()
            }
        });
    });
</script>
    <div id="header">
        <a id="logo" href="<?= base_url() ?>"></a>
        <div id="topnav">
            <ul>
                <li><a href="<?= base_url() ?>">İletişim</a></li>
                <li><a href="<?= base_url() ?>">Reklam</a></li>
                <li><a href="<?= base_url() ?>">Yardım</a></li>
                <li><a href="<?= base_url() ?>">Hakkımızda</a></li>
            </ul>
        </div>
        
        <div id="slogan"></div>
        <div id="split"></div>
        <a id="signup" href="<?=base_url()?>signup"></a>
        <div id="subslogan">Meslektaşlarınız sizi bekliyor. Meslektaşlarınızın arasına bugün katılın.</div>
        <div id="loginContainer">
            <form action="<?= base_url() ?>login" method="post" id="loginForm" name="loginForm">
            <? echo form_input(array("name"=>"l-email","id"=>"l-email","placeholder"=>"E-posta Adresiniz","style"=>"width:200px; border:0; margin:13px 5px 10px 35px")) ?>
            <? echo form_input(array("type"=>"password","name"=>"l-password","id"=>"l-password","placeholder"=>"Şifreniz","style"=>"width:200px; border:0; margin:15px 5px 20px 35px")) ?>
            <?php echo form_checkbox(array("id" => "rememberme", "name" => "rememberme", "checked" => "checked", "value" => "1")); ?> <label for="rememberme" style="font-size:11px;">Beni Hatırla</label><br>
            <a href="<?= base_url() ?>sifremi-unuttum" style="margin-top:5px; margin-left:5px; display:block; font-size:11px;">Şifremi Unuttum</a>
            </form>
        </div>
        <a id="login" href="javascript:void(0)" onclick="$('#loginForm').submit()"></a>
        <div id="nav">
            <ul>
                <li <?=($this->uri->segment(1)=="") ? 'class="selected"' : "" ?> ><a  class="home" href="<?= base_url() ?>"><span></span>Anasayfa</a></li>
                <li <?=($this->uri->segment(1)=="forumlar") ? 'class="selected"' : "" ?>><a class="forums" href="<?= base_url() ?>forumlar"><span></span>Forumlar</a></li>
                <li <?=($this->uri->segment(1)=="isbirligi") ? 'class="selected"' : "" ?>><a class="isbirlik" href="<?= base_url() ?>isbirligi"><span></span>İş Birliği</a></li>
                <li <?=($this->uri->segment(1)=="haberler") ? 'class="selected"' : "" ?>><a class="haberler" href="<?= base_url() ?>haberler"><span></span>Haberler</a></li>
                <li <?=($this->uri->segment(1)=="etkinlikler") ? 'class="selected"' : "" ?>><a class="etkinlikler" href="<?= base_url() ?>etkinlikler"><span></span>Etkinlikler</a></li>
                <li <?=($this->uri->segment(1)=="ilanlar") ? 'class="selected"' : "" ?>><a class="ilanlar" href="<?= base_url() ?>ilanlar"><span></span>İlanlar</a></li>
                <li <?=($this->uri->segment(1)=="firmalar") ? 'class="selected"' : "" ?>><a class="firmalar" href="<?= base_url() ?>firmalar"><span></span>Firmalar</a></li>
                <li <?=($this->uri->segment(1)=="makaleler") ? 'class="selected"' : "" ?>><a class="makaleler" href="<?= base_url() ?>makaleler"><span></span>Makaleler</a></li>
                <li <?=($this->uri->segment(1)=="videolar") ? 'class="selected"' : "" ?>><a class="videolar" href="<?= base_url() ?>videolar"><span></span>Videolar</a></li>
                <li <?=($this->uri->segment(1)=="download") ? 'class="selected"' : "" ?>><a class="download" href="<?= base_url() ?>download"><span></span>Download</a></li>
            </ul>
        </div>
    </div>

