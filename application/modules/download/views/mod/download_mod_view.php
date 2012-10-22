<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//form helper
$this->load->helper("form");
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
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/download">Download</a></li>
            <li>Yönetim</li>
        </ul>
    </div>
    
    <div style="float:left; width:480px; margin-top:10px;" align="right">
        <?php echo form_open(base_url().url_title($this->meslekname)."/admin/download", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <?php echo form_dropdown("dosyaCategory", $dosyaCategoryDropdown, isset($_GET["dosyaCategory"]) ? $_GET["dosyaCategory"] : "" , "id='dosyaCategory' style='padding:3px 4px 4px 4px; width:120px; border:1px solid #666666; font-size:11px;'"); ?>
        <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #666666; padding:4px; width:214px; font-size:11px;" placeholder="Dosyalarda arama yapın"/>         
        <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
        <?php echo form_close(); ?>
    </div>
    <div class="fix"></div>
    
    <div id="result" style="margin-top:5px;"></div>
    
    <div style="margin-top:10px; border-top:1px solid #CCCCCC;">

        <div style="padding:0px;">
            <? if (count($downloads) > 0) { ?>
                <table class="display" width="100%" cellpadding="6" cellspacing="0" style="border-top:1px solid #EEEEEE;">
                    <thead>
                        <tr>
                            <th>Tür</th>
                            <th>Dosya / Adı</th>
                            <th>Açıklaması</th>
                            <th>Kategori</th>
                            <th>Yükleyen</th>
                            <th>Yükleme Tarihi</th>
                            <th>Durumu</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($downloads AS $files): ?>
                        <tr>
                            <td width="">uzantı</td>
                            <td width="" style="font-size:11px;">
                                <a href="<?= base_url() ?><?=url_title($this->meslekname)?>/admin/download/yukle/<?=$files->id."/".setToken($files->id."download") ?>">
                                    <?=$files->name?>
                                    <br />
                                    <i>(<?=$files->fileurl?>)</i>
                                </a>
                            </td>
                            <td width="" style="font-size:11px;"><a href="<?= base_url() ?><?=url_title($this->meslekname)?>/admin/download/yukle/<?=$files->id."/".setToken($files->id."download") ?>"><?=$files->description?></a></td>
                            <td width="" style="font-size:11px;"><a href="<?=base_url().url_title($this->meslekname)."/admin/download"."?dosyaCategory=".$files->category?>"><?=$files->categoryName?></a></td>
                            <td width="" style="font-size:11px;"><a href="<?= base_url() ?>kullanici/<?=$files->user_id ?>" target="_blank"><?=$files->adsoyad?></a></td>
                            <td width="" style="font-size:11px; color:#666666;"><?= dateFormat($files->savedate, 'long') ?></td>
                            <td width="" style="font-size:11px; color:#666666;"><?=(($files->active == 1)?("Aktif"):("Pasif"))?></td>
                            <td width="" style="font-size:11px; color:#666666;">
                                <a onclick="window.location.href = '<?= base_url() ?><?=url_title($this->meslekname)?>/admin/download/yukle/<?=$files->id."/".setToken($files->id."download") ?>'" href="javascript:void(0);"><img src="images/icons/edit.png" /></a>
                                &nbsp;
                                <a onclick="dosyaSil(<?=$files->id.", ".setToken($files->id."download")?>);" href="javascript:void(0);"><img src="images/icons/cross.png" /></a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>

                </table>
            <? } else { ?> 
                <div class="warning"><?php echo lang("Aradığınız Kriterlere Uygun Kayıt Bulunamadı!") ?></div>
            <? } ?>
        </div>

        <?php if (count($downloads) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->download_mod_model->total_rows . "</b> " . lang("adet") . " " . lang("ilan kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->download_mod_model->total_rows;
                    $config['per_page'] = $this->config->item("ilan_rowperpage");
                    $config['query_string_segment'] = "s";
                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>
    </div>
</div>
