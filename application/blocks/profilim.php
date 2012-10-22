<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>


<div class="block">
    <div class="head"><img src="images/icons/user-yellow.png"/> Profilim</div>
    
<?
            if ($this->session->userdata("user_image") != "" && file_exists("public/images/user/" . $this->session->userdata("user_id") . "/thumb1/" . $this->session->userdata("user_image") . "")) {
                echo "<img style='float:left; margin:8px;' src='" . base_url() . "public/images/user/" . $this->session->userdata("user_id") . "/" . $this->session->userdata("user_image") . "'/>";
            } else {
                echo "<img style='float:left; margin:8px;' width='100' src='" . base_url() . "public/images/user_big.jpg'>";
            }
            ?>
    <div style="font-size:11px; line-height: 17px; padding:10px;">
            <span style="color:#CC0000; font-weight: normal; font-size:17px"> <?= $this->session->userdata("user_adsoyad") ?></span><br>
            <?= $this->session->userdata("user_meslekname") ?>
    </div>
    <div class="fix"></div>
    <div class="itemTitle"><img src="images/icons/wand--pencil.png"> Profil İşlemleriniz</div>
<ul class="profile">
    <li><a class="infoIcon" href="<?= base_url() ?>profilim/duzenle">Bilgilerimi Düzenle</a></li>
    <li><a class="passwordIcon" href="<?= base_url() ?>profilim/sifre-degistir">Şifre Değiştir</a></li>
    <li><a class="messagesIcon" href="<?= base_url() ?>profilim/mesajlarim">Mesajlarım</a></li>
    <li><a class="friendsIcon" href="<?= base_url() ?>profilim/arkadaslarim">Arkadaşlarım</a></li>
    <li><a class="settingsIcon" href="<?= base_url() ?>">Ayarlarım</a></li>
    <li><a class="settingsIcon" href="<?= base_url() ?>profilim/fotograf">Fotoğraf</a></li>
</ul>
</div>