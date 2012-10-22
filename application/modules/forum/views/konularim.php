<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div id="leftPanel">
     <? require APPPATH.'blocks/forumdan_son_konular.php'; ?>
     <? require APPPATH.'blocks/son_uyeler.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href='<?= base_url() ?>'>Anasayfa</a></li>
            <li><a href='<?= base_url() . url_title($this->session->userdata("user_meslekname")) ?>-forumlar'><?= $this->session->userdata("user_meslekname") ?> Forumlar</a></li>
            <li>Benim Konularım</li>
        </ul>
    </div>
    
    <div style="float:left; width:200px; margin-top:10px;">
        <img src="images/forums.png" style="vertical-align:bottom"/> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Forumlar</span>    
    </div>
    <div style="float:left; width:530px; margin-top:10px;" align="right">
        <input type="input" style="border:1px solid #666666; padding:4px; width:314px; font-size:11px;" placeholder="Forumlarda arama yapın"/>    
    </div>
    <div class="fix"></div>
    <div style="margin-top:10px; border-top:1px solid #CCCCCC;">
    
    <? 
     if (isset($konular) && count($konular) > 0) {
    ?>
    <table width="100%" cellpadding="5" cellspacing="0" style="">
 <tr>
           <tr>
            <td class="forumRow2">Konu</td>
            <td class="forumRow2">Tarih</td>
            <td class="forumRow2"></td>
            </tr>
        <?
       
            foreach ($konular as $row):
                ?>
                <tr style="border-bottom:1px solid #CCCCCC; font-size:11px;">
                    <td class="subForumRow" width="60%"><b style=" font-size:12px;"><a style="color:#2F547E; font-size:12px;" href='<?=base_url()."".url_title($row->meslek)."-forumlar/".url_title($row->forumname)."/".url_title($row->name)."-".$row->id."fk.html"?>'><?=$row->name ?></a></b><br><span style="font-size:11px; color:#666666;"><?=$row->adsoyad?></span></a></td>
                    <td class="subForumRow" width="20%" style="font-size:11px; color:#666666;"><?= dateFormat($row->savedate, "long") ?></td>
                    <td class="subForumRow" width="20%"><a href="<?=base_url()?>konu-duzenle/<?=$row->id?>?token=<?=setToken($row->id)?>">Düzenle</a></td>
                </tr>
            <?
            endforeach;
        ?>
        </table>
    <? 
    } else {
            ?><div class="warning">Henüz oluşturmuş olduğunuz konu bulunmamaktadır.</div>
            <? } ?>

                        <?php if (count($konular) > 0) { ?>
                    <div class="pagination">
                        <div style="width:200px; font-size:11px; color:#666666; float:left;">
                            <?php echo lang("Toplam") . " <b style='color:red'>" . $this->forum_model->total_rows . "</b> " . lang("adet") . " " . lang("konu bulundu!") ?>
                        </div>
                        <div style="float:left; text-align: right; width:500px;">
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

                            $config['num_links'] = 5;
                            $config['first_link'] = '|&lt;';
                            $config['prev_link'] = '&lt;';
                            $config['next_link'] = '&gt;';
                            $config['last_link'] = '&gt;|';
                            $config['page_query_string'] = true;
                            $config['base_url'] = base_url() . $this->uri->uri_string() . "?" . $url;
                            $config['total_rows'] = $this->forum_model->total_rows;
                            $config['per_page'] = 10;
                            $config['query_string_segment'] = "s";

                            $this->pagination->initialize($config);
                            echo $pagination = $this->pagination->create_links();
                            ?>
                        </div>

                    </div>
<? } ?>

          
    </div>
</div>