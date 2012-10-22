<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<div class="block">
    <div class="head">Firma Kategorileri</div>

    <ul class="category">

        <? $query = $this->db->query("SELECT id,name FROM site_firma_category WHERE meslek='" . $this->meslekid . "' ");
        foreach ($query->result() as $cat): ?>
            <?
            $query2 = $this->db->query("SELECT id FROM site_firma WHERE active='1' AND category='" . $cat->id . "'");
            ?>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/firmalar?category=<?= $cat->id ?>"> <img src="images/icons/shortcut-small.png"/> <?= $cat->name ?> <?= ($query2->num_rows() > 0 ) ? "<span style='color:#999999'>(" . $query2->num_rows() . ")</span>" : "" ?></a></li>
        <? endforeach; ?>
    </ul>
</div>

