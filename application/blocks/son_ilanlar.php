<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div class="block">
    <div class="head"><img src="images/icons/document-pdf-text.png"/> Son Eklenen İlanlar</div>
    <div style="padding:10px; padding-top:0;">
<?
$sql = "SELECT site_ilan.* FROM site_ilan INNER JOIN site_ilan_category ON site_ilan.category=site_ilan_category.id WHERE site_ilan_category.meslek='".$this->meslekid."' ORDER BY savedate DESC LIMIT 0,5";
$query = $this->db->query($sql);

foreach ($query->result() as $ilan){
    ?>
<div class="borderbottom" style="padding:8px 10px 10px 0;"><a style="" href="<?=base_url()?><?=url_title($this->meslekname)?>/ilanlar/<?=url_title($ilan->name)?>-<?=$ilan->id?>i.html">
          
        <div style="line-height: 17px; font-size:11px; color: #333333; height:70px; display:block; overflow:hidden;">
          
            <div class="fix"></div>
        </div>
    <?
}
?>
    </div>
</div>