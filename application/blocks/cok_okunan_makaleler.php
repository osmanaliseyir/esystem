<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div class="block">
    <div class="head">Çok Okunan Makaleler</div>
    <div style="padding:10px; padding-top:0;">
        <?
$sql = "SELECT site_makale.* FROM site_makale INNER JOIN site_makale_category ON site_makale.category=site_makale_category.id WHERE site_makale_category.meslek='".$this->meslekid."' ORDER BY readnum ASC LIMIT 0,5";
        $query = $this->db->query($sql);

        foreach ($query->result() as $haber) {
            ?>
            <div class="borderbottom" style="padding:10px 10px 10px 0;"><a style="" href="<?= base_url().url_title($this->meslekname) ?>/haberler/<?= url_title($haber->name) ?>-<?= $haber->id ?>h.html">
                
                    <div style="font-size:11px; color: #333333; display:block; overflow:hidden;">
                        <img src="images/icons/document-pdf-text.png"/><b style="color:#2F547E"> <?= $haber->name ?><br/></b>
                    </div>
                    <div class="fix"></div>
                </a>
           
            </div>
            <?
        }
        ?>
    </div>
</div>