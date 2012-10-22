<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div class="block">
    <div class="head"><img src="images/icons/newspaper--arrow.png"/> Son Haberler</div>
    <div style="padding:10px; padding-top:0;">
<?


$sql = "SELECT site_haber.* FROM site_haber INNER JOIN site_haber_category ON site_haber.category=site_haber_category.id WHERE site_haber_category.meslek='".$this->meslekid."' ORDER BY savedate DESC LIMIT 0,5";
$query = $this->db->query($sql);

foreach ($query->result() as $haber){
    ?>
<div class="borderbottom" style="padding:8px 10px 10px 0;"><a style="" href="<?=base_url()?><?=url_title($this->meslekname)?>/haberler/<?=url_title($haber->name)?>-<?=$haber->id?>h.html">
            
                <?
                if($haber->image!="" && file_exists("public/images/haber/thumb/".$haber->image."")){
                    echo "<img style='float:left; margin-right:8px; border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/haber/thumb/".$haber->image."'>";
                } else {
                    echo "<img style='float:left; margin-right:8px;border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/haber.jpg'>";
                }
                ?>
            
        <div style="line-height: 17px; font-size:11px; color: #333333; height:70px; display:block; overflow:hidden;">
            <b style="color:#2F547E"><?=$haber->name?><br/></b>
            <?=$haber->subtitle?></div>
            
            <div class="fix"></div></a>
        </div>
    <?
}
?>
    </div>
</div>