<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper("form");
?>
<script type="text/javascript">

    $(function(){
        $("#characters a").tipsy();
    })
</script>
<div id="leftPanel" style="width:200px;">
    <div class="subMenu">
    <ul>
        <li><a href="<?=base_url().url_title($this->meslekname)?>/firmalar/firmalarim"><img src="images/icons/tickets.png"/> Firmalarım</a></li>
        <li><a href="<?=base_url().url_title($this->meslekname)?>/firmalar/ekle"><img src="images/icons/ticket--plus.png"/> Yeni Firma Ekle</a></li>
    </ul>
    </div>
    <? require APPPATH."blocks/firma_kategorileri.php" ?>
</div>
<div id="rightPanel" style="width:550px;">

    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/firmalar">Firmalar</a></li>
        </ul>
    </div>
    
    <div style="float:left; width:226px; margin-top:10px;">
        <img src="images/firmalar.png" style="vertical-align:bottom"/> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Firmalar</span>    
    </div>
    <div style="float:left; width:280px; margin-top:10px;" align="right">
        <?php echo form_open(base_url() .url_title($this->meslekname). "/firmalar/detayliarama", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <input type="input" name="q" value="<?=(isset($_GET["q"])) ? $_GET["q"] : ""?>" style="border:1px solid #999999; padding:4px; width:314px; font-size:11px;" placeholder="Firmalarda arama yapın"/>    
        <?php echo form_close() ?>

    </div>
    <div class="fix"></div>

    <div style="margin-top:10px; border-top:1px solid #CCCCCC; padding-top:10px;" id="characters">
        <ul>
            <li><a title="<?php echo lang("A harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=a">A</a></li>
            <li><a title="<?php echo lang("B harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=b">B</a></li>
            <li><a title="<?php echo lang("C harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=c">C</a></li>
            <li><a title="<?php echo lang("Ç harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=c">Ç</a></li>
            <li><a title="<?php echo lang("D harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=d">D</a></li>
            <li><a title="<?php echo lang("E harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=e">E</a></li>
            <li><a title="<?php echo lang("F harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=f">F</a></li>
            <li><a title="<?php echo lang("G harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=g">G</a></li>
            <li><a title="<?php echo lang("H harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=h">H</a></li>
            <li><a title="<?php echo lang("I harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=i">I</a></li>
            <li><a title="<?php echo lang("İ harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=i">İ</a></li>
            <li><a title="<?php echo lang("J harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=j">J</a></li>
            <li><a title="<?php echo lang("K harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=k">K</a></li>
            <li><a title="<?php echo lang("L harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=l">L</a></li>
            <li><a title="<?php echo lang("M harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=m">M</a></li>
            <li><a title="<?php echo lang("N harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=n">N</a></li>
            <li><a title="<?php echo lang("O harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=o">O</a></li>
            <li><a title="<?php echo lang("Ö harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=o">Ö</a></li>
            <li><a title="<?php echo lang("P harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=p">P</a></li>
            <li><a title="<?php echo lang("R harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=r">R</a></li>
            <li><a title="<?php echo lang("S harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=s">S</a></li>
            <li><a title="<?php echo lang("Ş harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=s">Ş</a></li>
            <li><a title="<?php echo lang("T harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=t">T</a></li>
            <li><a title="<?php echo lang("U harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=u">U</a></li>
            <li><a title="<?php echo lang("Ü harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=u">Ü</a></li>
            <li><a title="<?php echo lang("V harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=v">V</a></li>
            <li><a title="<?php echo lang("Y harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=y">Y</a></li>
            <li><a title="<?php echo lang("Z harfi ile Başlayan Firmalar") ?>" href="<?php echo base_url().url_title($this->meslekname) ?>/firmalar/detayliarama?harf=z">Z</a></li>
        </ul>
    </div>
    <div style="padding:10px 0">


        <?php
        if (count($firmalar) > 0) {
            foreach ($firmalar as $firma):
                ?>
                <div class="firmaContainer">
                    <div class="logo">
                        <?
                        if ( $firma->logo!="" && file_exists("public/images/firma/thumb/" . $firma->logo . "")) {
                            echo "<img width='100' style='padding:2px; float:left; margin-right:5px; border:1px solid #CCCCCC;' src='" . base_url() . "public/images/firma/thumb/" . $firma->logo . "'>";
                        } else {
                            echo "<img width='100' style='padding:2px; float:left; margin-right:5px; border:1px solid #CCCCCC;' src='" . base_url() . "public/images/firma_logo.jpg'>";
                        }
                        ?>

                    </div>
                    <div class="description"> <a href="<?=base_url().url_title($this->meslekname)?>/firmalar/<?=url_title($firma->name)?>-<?=$firma->id?>c.html" style="font-size:14px; font-weight: bold;"><?php echo $firma->name ?></a><br/>

                        <table width="100%" cellspacing="0" style="font-size:11px;">
                            <tr>
                                <td width="20"><img width="12" src='images/category.png'/></td>
                                <td><span style='color:#666666;'><?php echo $firma->categoryname ?></span></td>
                            </tr>
                            <tr>
                                <td><img width="12" src='images/maps.png'/></td>
                                <td><?php echo $firma->il . "/" . $firma->ilce ?></span></td>
                            </tr>
                            <tr>
                                <td><img width="12" src='images/telephone.png'/></td>
                                <td><?php echo $firma->sabittel ?></span></td>
                            </tr>
                            <tr>
                                <td><img width="12" src='images/mobile-phone-cast.png'/></td>
                                <td><?php echo $firma->ceptel ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="buttons">
                        <a class="button-yellow" href="<?php echo base_url() ?>firmalar/detay/<?= $firma->id ?>"><?php echo lang("Firma Detayı") ?></a>
                    </div>
                </div>
            <? endforeach;
        } else { ?> 
            <div class="warning"><?php echo lang("Aradığınız Kriterlere Uyan Firma Kaydı Bulunamadı!") ?></div>
        <? } ?>
    </div>

    <?php if (count($firmalar) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->firma_model->total_rows . "</b> " . lang("adet") . " " . lang("firma kaydı bulundu!") ?>
                </div>
                <div style="float:left; text-align: right; width:443px;">
                    <?php
                    $this->load->library('pagination');
                    $url = "";
                    $i = 0;
                    if (isset($_GET)) {
                        foreach ($_GET as $k => $v) {
                            $i++;
                            if ($k != "s")
                                $url.=$k . "=" . $v;
                            $url.=($i != count($_GET)) ? "&" : "";
                        }
                    }



                    $config['prev_link'] = '&lt;' . lang("Önceki");
                    $config['next_link'] = lang("Sonraki") . '&gt;';
                    $config['page_query_string'] = true;
                    $config['base_url'] = base_url() . $this->uri->uri_string() . "?" . $url;
                    $config['total_rows'] = $this->firma_model->total_rows;
                    $config['per_page'] = $this->config->item("ilan_rowperpage");
                    $config['query_string_segment'] = "s";


                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>

</div>
<div style="float:left; width: 200px; margin:10px 10px 10px 0;">
    <div class="itemTitle">Sponsor Firmalar</div>
</div>
