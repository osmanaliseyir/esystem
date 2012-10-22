<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper(array("form", "date"));
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<div id="leftPanel">
    <? require APPPATH . 'blocks/profilim.php'; ?>   

</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li><a href="<?= base_url() ?>profilim/mesajlarim">Mesajlarım</a></li>
            <li>Mesaj Detayı</li>
        </ul>
    </div>

    <div style="padding:10px;">
        <table width="100%" cellpadding="6" cellspacing="0" class="formTable">
            <tr>
                <td width="20%"><?php echo lang("Gönderen", "label") ?></td>
                <td><a href='<?= base_url() . "kullanici/" . $data->from ?>'><?php echo $data->sender ?></a></td>
            </tr>
            <tr>
                <td><?php echo lang("Tarih", "label") ?></td>
                <td><?php echo dateFormat($data->savedate, "long") ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Mesaj Başlığı", "label") ?></td>
                <td><?php echo $data->name ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:14px; padding:10px;">
                    <?php echo $data->description ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><?php echo form_button(array("content" => lang("Cevap Yaz"), "style" => "width:200px;", "class" => "blue", "onclick" => "window.location='" . base_url() . "profilim/mesajlarim/add?reply=" . $data->id . "&token=" . setToken($data->id) . "'")) ?></td>
            </tr>
        </table>
    </div>
</div>
