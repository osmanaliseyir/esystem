<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$this->load->helper("date");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<div id="leftPanel">
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">

    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/download">Download</a></li>
            <li>Arama Sonuçları</li>
        </ul>
    </div>

   
    
    <div style="float:left; width:350px; margin-top:10px;">
        <img src="images/download.png"> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Arama Sonuçları</span>
    </div>
    
    <div style="float:left; width:310px; margin-top:10px;" align="right">
        <?php echo form_open(base_url().url_title($this->meslekname)."/download/search", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #666666; padding:4px; width:214px; font-size:11px;" placeholder="Dosyalarda arama yapın"/>         
        <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
        <?php echo form_close(); ?>
    </div>
    <div class="fix"></div>
    
    <div id="result" style="margin-top:5px;"></div>
    
    <div style="margin-top:10px; border-top:1px solid #CCCCCC;">

        <div style="">
            <? if (count($dosyalar) > 0) { ?>
                    <?php foreach ($dosyalar AS $dosya): ?>
            <div style="float:left; padding:30px 0 20px 0; width:310px; height: 80px; margin-right: 20px;" class="borderbottom">
                            
                    
                <? 
                $extension = strrchr($dosya->fileurl, ".");
                $extension = str_replace(".", "", $extension);
                ?>
                <img style="float:left; margin-right:8px;" src="<?=base_url()?>public/images/mimetypes/<?=$extension?>-icon-48x48.png"/>
                <div style="float:left; width:230px; height:60px; margin-bottom:6px; display: block; overflow: hidden;">
                     <b><?=$dosya->name?></b><br>
                     <div class="smalldesc" style="color:#666666; margin-top:5px;"><?=$dosya->description?></div>
                </div>
                       
                        
                        <div style="float:left;">
                            <a href="<?=base_url().url_title($this->meslekname)?>/download/file/<?=$dosya->id?>"><img src="images/download.jpg"/></a>
                        </div>
                <div style="font-size:11px; padding: 6px 0 0 4px; color:#999999; float:right;"> 
                            <img src="images/blocker.jpg"/> <?=dateFormat($dosya->savedate,"long")?>&nbsp;&nbsp;&nbsp;
                            <img src="images/blocker.jpg"/> İndirme:<?=$dosya->downloadnum?></div>
                        
            </div>
                    <? endforeach; ?>
            <? } else { ?> 
                <div class="warning">"<?=(isset($_GET["q"])) ? $_GET["q"] : ""?>" kelimesine uyan dosya bulunamadı!</div>
            <? } ?>
        </div>
                

        <div class="fix"></div>
        
        <?php if (count($dosyalar) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->download_model->total_rows . "</b> " . lang("adet") . " " . lang("ilan kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->download_model->total_rows;
                    $config['per_page'] = 20;
                    $config['query_string_segment'] = "s";
                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>
    </div>
    
</div>
