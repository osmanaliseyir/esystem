<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<div class="block">
    <div class="head">İlan Kategorileri</div>

    <ul class="category">

        <? $query = $this->db->query("SELECT id,name FROM site_ilan_category WHERE meslek='" . $this->meslekid . "' ");
        foreach ($query->result() as $cat): ?>
            <?
            $query2 = $this->db->query("SELECT id FROM site_ilan WHERE active='1' AND category='" . $cat->id . "'");
            ?>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar?category=<?= $cat->id ?>"> <img src="images/icons/shortcut-small.png"/> <?= $cat->name ?> <?= ($query2->num_rows() > 0 ) ? "<span style='color:#999999'>(" . $query2->num_rows() . ")</span>" : "" ?></a></li>
        <? endforeach; ?>
    </ul>
</div>

