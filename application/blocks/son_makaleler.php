<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div class="block">
    <div class="head"><img src="images/icons/document-pdf-text.png"/> Son Makaleler</div>
    <div style="padding:10px; padding-top:0;">
<?
$sql = "SELECT site_makale.* FROM site_makale INNER JOIN site_makale_category ON site_makale.category=site_makale_category.id WHERE site_makale_category.meslek='".$this->meslekid."' ORDER BY savedate DESC LIMIT 0,5";
$query = $this->db->query($sql);

foreach ($query->result() as $makale){
    ?>
<div class="borderbottom" style="padding:8px 10px 10px 0;"><a style="" href="<?=base_url()?><?=url_title($this->meslekname)?>/makaleler/<?=url_title($makale->name)?>-<?=$makale->id?>h.html">
            
                <?
                if($makale->image!="" && file_exists("public/images/makale/thumb/".$makale->image."")){
                    echo "<img style='float:left; margin-right:8px; border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/makale/thumb/".$makale->image."'>";
                } else {
                    echo "<img style='float:left; margin-right:8px;border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/makale.jpg'>";
                }
                ?>
            
        <div style="line-height: 17px; font-size:11px; color: #333333; height:70px; display:block; overflow:hidden;">
            <b style="color:#2F547E"><?=$makale->name?><br/></b>
            <?=$makale->subtitle?></div>
            
            <div class="fix"></div></a>
        </div>
    <?
}
?>
    </div>
</div>