<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type="text/javascript">
    function changeMansetItem(id){
        $(".manset_images div").css("display","none");
        $("#manset_image_"+id).css("display","block");
        $("#manset_image_"+id+" div" ).css("display","block");
    }
</script>
<? $query = $this->db->query("SELECT site_haber.* FROM site_haber INNER JOIN site_haber_category ON site_haber.category=site_haber_category.id WHERE site_haber_category.meslek='".$this->meslekid."' ORDER BY savedate DESC LIMIT 0,12"); ?> 

<div style="float:left; width:300px; height:300px; padding:3px;">
    <div class="manset_images">
        <? $i = 0;
        foreach ($query->result() as $manset): $i++; ?>

            <? if ($manset->image != "" && file_exists("public/images/haber/thumb2/" . $manset->image . "")) { ?>
                <div id='manset_image_<?= $manset->id ?>' style='<?= ($i == 1) ? "" : "display:none;" ?>'>
                    <img style='border:1px solid #CCCCCC; padding:3px;'  src='<?= base_url() . "public/images/haber/thumb2/" . $manset->image ?>'>
                        <div style="font-size:12px; line-height: 20px; color:#666666;"><?= $manset->subtitle ?></div>
                </div>
            <? } else { ?>
                <div id='manset_image_<?= $manset->id ?>' style='<?= ($i == 1) ? "" : "display:none;" ?>'>
                    <img style='border:1px solid #CCCCCC; padding:3px;' id='manset_image_<?= $manset->id ?>' src='<?= base_url() ?>public/images/haber2.jpg'>
                        <div><?= $manset->subtitle ?></div>
                </div>
            <? } ?>

        <? endforeach; ?>  
    </div>
</div>
<div style="width:340px; margin-left:10px; float:left;"><ul class="mansetHaber">
        <? foreach ($query->result() as $manset): ?>
            <li><a onmouseover="changeMansetItem(<?= $manset->id ?>)" href="<?= base_url() ?><?= url_title($this->meslekname) ?>/haberler/<?= url_title($manset->name) ?>-<?= $manset->id ?>h.html"><?= $manset->name ?></a></li>
        <? endforeach; ?>            
    </ul>
</div>
