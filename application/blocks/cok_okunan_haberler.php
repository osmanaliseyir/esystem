<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div class="block">
    <div class="head"><img src="images/icons/newspapers.png"/> Çok Okunan Haberler</div>
    <div style="padding:10px; padding-top:0;">
        <?
        $sql = "SELECT * FROM site_haber WHERE category='" . $this->meslekid . "' ORDER BY readnum DESC LIMIT 0,5";
        $query = $this->db->query($sql);

        foreach ($query->result() as $haber) {
            ?>
            <div class="borderbottom" style="padding:10px 10px 10px 0;"><a style="" href="<?= base_url() ?><?= url_title($this->meslekname) ?>/haberler/<?= url_title($haber->name) ?>-<?= $haber->id ?>h.html">
                
                    <div style="font-size:11px; color: #333333; display:block; overflow:hidden;">
                        <b style="color:#2F547E"><?= $haber->name ?><br/></b>
                    <div class="fix"></div>
            </div></a>
            </div>
            <?
        }
        ?>
    </div>
</div>