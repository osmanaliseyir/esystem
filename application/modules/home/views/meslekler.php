<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<style>
    #mesleklist { list-style: none; list-style-image: none; margin: 0; padding:0;}
    #mesleklist li { float: left; width:192px; height: 24px;}
    #mesleklist li a { display: block;}
</style>

<div style="padding:10px; width:972px; display: inline-block ">
    <div align="center">
        <h2>Diğer Mesleklere de bir göz atın!</h2>
        <div style=" font-size:14px;">
            <? 
            $query=$this->db->query("SELECT count(id) as mesleksayi FROM site_meslek WHERE active='1'");
            $row=$query->row();
            ?>
            
            Sitemizde toplam <?=$row->mesleksayi?> meslek vardır. E-meslek sadece kendi meslektaşlarınızla değil, 
            diğer meslek çalışanları ile de sizi iletişime geçirmektedir.<br>
            <form action="<?=base_url().url_title($this->meslekname)?>/meslekler" method="get">
            <input type="text" name="meslek" value="<?=(isset($_GET["meslek"])) ? $_GET["meslek"] : ""?>" style="font-size:14px; padding:4px; width:400px; margin:10px 0;" placeholder="Arayacağınız mesleği yazınız!"/>
            </form>
        </div>
        <h2>Meslekler</h2> <div class="smalldesc">A'dan Z'ye sıralı meslek listemizi aşağıda bulabilirsiniz!</div>
    </div>
    <div style="padding:10px 0; border-top:1px solid #CCCCCC; margin:10px 0;">
    <? foreach ($meslekler as $key=>$meslek): if($key!=0) { ?>
        <ul id="mesleklist">
            <li><a href='<?= base_url() . url_title($meslek) ?>'><?= $meslek ?></a></li>
        </ul>
    <? } endforeach; ?>
        </div>
</div>

