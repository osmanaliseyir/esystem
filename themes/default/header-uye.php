<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>

<div style="height:76px; margin:3px auto; width:994px;"> 

    <div id="userContainer">
        <?
        if ($this->session->userdata("user_image") != "" && file_exists("public/images/user/" . $user_id . "/thumb1/" . $this->session->userdata("user_image") . "")) {
            echo "<img src='" . base_url() . "public/images/user/" . $this->session->userdata("user_id") . "/thumb1/" . $this->session->userdata("user_image") . "'/>";
        } else {
            echo "<img src='" . base_url() . "public/images/user.jpg'>";
        }
        ?>
        <div style="float:left; font-size:12px; padding:10px 4px 8px 4px;color:#555555; ">
            <b><?= $this->session->userdata("user_adsoyad") ?></b><br>
            <?= $this->session->userdata("user_meslekname") ?>
        </div>
    </div>
    
    <div style="float: left; font-size:14px; padding:10px;">
        
        <? 
        $query= $this->db->query("SELECT type FROM site_yetkilendirme WHERE user_id='".$this->session->userdata("user_id")."' and meslek_id='".$this->meslekid."'");
        $row=$query->row();
        
        if(isset($row->type) && ($row->type==1 || $row->type==2)){
        ?>
        <?=$this->session->userdata("user_meslekname")?> Mesleğinde <?=($row->type==1) ? "Adminsiniz" : "Moderatörsünüz"?>. &nbsp;<a href="<?=base_url().url_title($this->meslekname)?>/admin">[Yönetim Paneli]</a>
        <?  
        } else {
        ?>
        
        <? $users = $this->db->query("SELECT id FROM site_users WHERE meslek='".$this->session->userdata("user_meslek")."'");?>
        <?=$this->session->userdata("user_meslekname")?> Mesleğinde toplam <?=$users->num_rows?> meslektaşınız bulunmakta. Meslektaşlarınızla iletişime geçmek için doğru adrestesiniz! 
        <? } ?>
    </div>
    
    <?
    $query = $this->db->query("SELECT id FROM site_messages WHERE `read`='0' AND `to`='" . $this->session->userdata("user_id") . "'");
    $mesaj_sayisi=($query->num_rows()>99) ? "99" : $query->num_rows();
    $query2 = $this->db->query("SELECT id FROM site_bildirim WHERE `read`='0' AND `user_id`='" . $this->session->userdata("user_id") . "'");
    $query3 = $this->db->query("SELECT id FROM site_arkadas WHERE `active`='0' AND `friend_id`='" . $this->session->userdata("user_id") . "'");
    $bildirim_sayisi=($query2->num_rows()>99) ? "99" : $query2->num_rows();
    $arkadas_sayisi=($query3->num_rows()>99) ? "99" : $query3->num_rows();

    ?>
    <ul id="headerUserMenu">
        <li class="menu100"><a href="<?= base_url() ?>profilim"><img src='images/profile-white.png'/> Profilim</a></li>
        <li class="blocker"></li>
        <li class="menu100"><a href="<?= base_url() ?>profilim/mesajlarim"><img src='images/messages-white.png'/> Mesajlar <?= ($mesaj_sayisi>0) ? "<span>" .$mesaj_sayisi . "</span>" : "" ?></a></li>
        <li class="blocker"></li>
        <li class="menu100"><a href="<?= base_url() ?>profilim/bildirimler"><img src='images/tasks-white.png'/> Bildirimler <?= ($bildirim_sayisi> 0 ) ? "<span>" . $bildirim_sayisi . "</span>" : "" ?></a></li>
        <li class="blocker"></li>
        <li class="menu120"><a href="<?= base_url() ?>profilim/arkadaslarim"><img src='images/friends-white.png'/> Arkadaşlarım <?= ($arkadas_sayisi> 0 ) ? "<span>" . $arkadas_sayisi . "</span>" : "" ?></a></li>
        <li class="blocker"></li>
        <li class="menu100"><a href="<?= base_url() ?>profilim/ayarlar"><img src='images/settings-white.png'/> Ayarlarım</a></li>
        <li class="blocker"></li>
        <li class="menu100"><a href="<?= base_url() ?>cikis-yap"><img src='images/logout-white.png'/> Çıkış Yap</a></li>

    </ul>


</div>
<div class="fix"></div>
