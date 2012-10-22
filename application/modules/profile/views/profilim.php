<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>

<div id="leftPanel">
        <? require APPPATH . 'blocks/profilim.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li>Profilim</li>
        </ul>
    </div>
    <div class="fix"></div>
</div>
