<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");



//Kullanıcılar
$query = $this->db->query("SELECT id FROM site_users wHERE meslek='" . $this->meslekid . "'");
$ist_users = $query->num_rows();

//İlanlar
$query2 = $this->db->query("SELECT site_ilan.id FROM site_ilan INNER JOIN site_ilan_category ON site_ilan.category=site_ilan_category.id WHERE site_ilan_category.meslek='" . $this->meslekid . "'");
$ist_ilans = $query2->num_rows();
?>
<div class="block">
    <div class="head"><img src='images/icons/block.png'/> <?= lang("İstatistikler") ?></div>
    <div style="padding:10px; font-size:11px; line-height: 20px; color:#333333;">
        <a href='<?=base_url().url_title($this->meslekname)?>'><?= $this->meslekname ?></a> mesleğine ait<br>
        <img src='images/icons/users.png'> <?= $ist_users ?> Kullanıcı, 
        <img src='images/icons/ticket.png'> <?= $ist_ilans ?> İlan


    </div>

</div>

