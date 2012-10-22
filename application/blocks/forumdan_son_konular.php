<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<div class="block">
    <div class="head"><img src="images/icons/balloon-ellipsis.png"> Forumdan Son Konular</div>
    <div style="padding:8px;">
        <?
        $this->load->helper("date");

        $sql = "SELECT * FROM site_forum_konu_view WHERE meslek='" . $this->meslekname . "' AND type='1' ORDER BY savedate DESC LIMIT 0,6";
        $query = $this->db->query($sql);

        foreach ($query->result() as $mesaj) {
            ?>
            <div style="padding:3px 10px 3px 0; border-bottom:1px solid #EEEEEE; ">          
                <div style="line-height: 17px; color: #333333; height:40px; display:block; overflow:hidden;">
                    <div style="float:left; width:55px;">
                        <?
                        if ($mesaj->image != "" && file_exists("public/images/user/" . $mesaj->user_id . "/thumb/" . $mesaj->image . "")) {
                            echo "<a href='" . base_url() . "kullanici/" . $mesaj->user_id . "'><img class='ttip' title='" . $mesaj->adsoyad . "' src='" . base_url() . "public/images/user/" . $mesaj->user_id . "/thumb/" . $mesaj->image . "'></a>";
                        } else {
                            echo "<a href='" . base_url() . "kullanici/" . $mesaj->user_id . "'><img class='ttip' title='" . $mesaj->adsoyad . "' width='44' src='" . base_url() . "public/images/user.jpg'></a>";
                        }
                        ?>
                    </div>
                    <div style="float:left; padding-top:3px; color:#333333; font-size:11px; width:200px;">
                        <b><a style="color:#333333" href='<?= base_url() ?><?= url_title($mesaj->meslek) ?>/forumlar/<?= url_title($mesaj->forumname) ?>/<?= url_title($mesaj->name) ?>-<?= $mesaj->id ?>fk.html'><?= $mesaj->name ?></a><br/></b>
    <?= substr(strip_tags($mesaj->description), 0, 100) ?></div>
                </div>
                <div class="fix"></div>
            </div>
            <?
        }
        ?>
    </div>
</div>