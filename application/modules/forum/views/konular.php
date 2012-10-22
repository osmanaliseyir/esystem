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
            <li><a href='<?= base_url() . $data["meslek"]["url"] ?>/forumlar'><?= $data["meslek"]["name"] ?> Forumu</a></li>
            <li><a href='javascript:void(0)'><?= $data["forum"]["name"] ?></a></li>
            <li><a href='<?= base_url() . $data["meslek"]["url"] ?>/forumlar/<?= url_title($data["altforum"]["name"]) ?>-<?= $data["altforum"]["id"] ?>f.html'><?= $data["altforum"]["name"] ?></a></li>
        </ul>
    </div>
    
     <div style="float:left; width:200px; margin-top:10px;">
        <img src="images/forums.png" style="vertical-align:bottom"/> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Forumlar</span>    
    </div>
    <div style="float:left; width:460px; margin-top:10px;" align="right">
        <input type="input" style="border:1px solid #666666; padding:4px; width:314px; font-size:11px;" placeholder="Forumlarda arama yapın"/>    
    </div>
    <div class="fix"></div>
    <div style="padding-top:0px; margin-top:10px; border-top:1px solid #CCCCCC;">
    
    <table width="100%" cellpadding="5" cellspacing="0" style="">
 <tr>
     <td height="60" style="line-height: 17px; color:#666666;">
         <b style="color:#2F547E;"><?=$data["altforum"]["name"];?></b><br>
         <span style='font-size:11px;'><?=$data["altforum"]["description"];?></span>
     </td>
            <td align="right"><a href='<?= base_url() ?><?= $this->uri->segment(1) ?>/forumlar/konu-ekle/<?= $data["altforum"]["id"] ?>'><img src="images/yeni_konu.jpg"></a></td>
        </tr>
        <tr style="background: #EEEEEE; font-size:11px;">
            <td colspan="2" class="forumRow"><?php echo $data["altforum"]["name"]; ?></td>
        </tr>
        <tr>
            <td class="forumRow2">Konu</td>
            <td class="forumRow2">Tarih</td>
        </tr>
        <?
        if (isset($data["konular"]) && count($data["konular"]) > 0) {
            foreach ($data["konular"] as $id => $sub):
                ?>
                <tr style="border-bottom:1px solid #CCCCCC; font-size:11px;">
                    <td class="subForumRow" width="60%"><a href='<?= base_url() ?><?= $this->uri->segment(1) ?>/<?= url_title($data["altforum"]["name"]) ?>/<?= url_title($sub->name) ?>-<?= $sub->id ?>fk.html'><?php echo "<b>" . $sub->name . "</b><br><a style='font-size:11px; color:#666666;' href='".base_url()."kullanici/".$sub->user_id."'>" . $sub->adsoyad . "</a>"; ?></a></td>
                    <td class="subForumRow" width="20%"><span style='color:#666666; font-size:11px;'><?= dateFormat($sub->savedate, "long") ?></span></td>
                </tr>
            <?
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan='3' class="subForumRow">Bu forumda henüz konu bulunmamaktadır. İlk konuyu siz oluşturun.</td>
            </tr>
            <?
        }
        ?>
        </table>
    </div>

                        <?php if (count($data["konular"]) > 0) { ?>
                    <div class="pagination">
                        <div style="width:200px; font-size:11px; color:#666666; float:left;">
                            <?php echo lang("Toplam") . " <b style='color:red'>" . $this->forum_model->total_rows . "</b> " . lang("adet") . " " . lang("konu bulundu!") ?>
                        </div>
                        <div style="float:left; text-align: right; width:460px;">
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