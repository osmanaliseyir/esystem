<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

?>
<div id="leftPanel">
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">
   
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/download">Download</a></li>
        </ul>
    </div>
    
    <div style="float:left; width:180px; margin-top:10px;">
        <img src="images/download.png"> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Download</span>
    </div>
    
    <div style="float:left; width:480px; margin-top:10px;" align="right">
        <?php echo form_open(base_url().url_title($this->meslekname)."/download/search", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #666666; padding:4px; width:214px; font-size:11px;" placeholder="Dosyalarda arama yapın"/>         
        <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
        <?php echo form_close(); ?>
    </div>
    
    <div style="clear:both"></div>
    
    <div style="margin-top:10px; padding-top: 20px; border-top:1px solid #CCCCCC;">
    <? foreach($kategoriler as $kategori): ?>
    <div style="float:left; width:210px; height:60px; margin-left: 10px;">
        <a href="<?=base_url().url_title($this->meslekname)?>/download/<?=url_title($kategori->name)?>-<?=$kategori->id?>dk.html"><b><?=$kategori->name?></b> (<?=$kategori->sayi?>)</a><br>
        <div style="margin-top:5px;" class='smalldesc'><?=$kategori->description?></div>
    </div>
    <? endforeach; ?>
        </div>
</div>
