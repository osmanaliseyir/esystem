<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<style>
    .hidden { display:none}
</style>
<script type="text/javascript">
    $(function(){
        $("#meslek").keyup(function () {            
            var filter = $(this).val(), count = 0;
            $(".filtered:first li a").each(function () {
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).parent().addClass("hidden");
                } else {
                    $(this).parent().removeClass("hidden");
                    count++;
                }
            });
            $("#filter-count").text(count);
        });
    });
</script>

<div class="block" style="font-size:11px;">
    <div class="head">Meslek Seçimi</div>
    <div style="padding:10px;" id="mesleksecimi">
        <input type="text" name="meslek" id="meslek" placeholder="Aradığınız mesleği seçiniz" style=" padding:5px 3px 2px 4px; border: 1px solid #CCCCCC;; font-size:11px; width:270px;"/>
        <div id="meslekResultDiv" style=" margin:12px 0 0 8px; height: 150px; width:276px; overflow:auto; display: block;"> 
            <div id="filet-count"></div>
            <ul class="filtered">
                <?
                $query = $this->db->query("SELECT name,urlname FROM site_meslek WHERE active='1' ");
                foreach ($query->result() as $meslek):
                    ?>
                    <li><a href='<?= base_url() ?><?= $meslek->urlname ?>'><?= $meslek->name ?></a></li>
                <? endforeach; ?>
            </ul>
        </div>

    </div>
</div>
