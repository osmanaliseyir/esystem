<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<script type="text/javascript">
 function itemDelete(id,token){
        var u=confirm('<?php echo lang("Seçmiş olduğunuz kullanıcıyı silmek istediğinize emin misiniz?") ?>');
        if(u){
            $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
            $.ajax({
                type:'POST',
                url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/kullanicilar/delete/'+id+'?token='+token,
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz kullanıcı silinmiştir.") ?> "));
                        setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/kullanicilar'",2000);
                    }else if (respond.success=="false") {
                        $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz kullanıcı silinemedi!") ?>"));
                    }
                }
            }); 
        }
    }
</script>

<div id="leftPanel">
    <? require APPPATH."blocks/admin_yetki.php"; ?>
</div>
<div id="rightPanel">
    
    <div id="result"></div>
    
    <div class="block">
        <div class="head">Kullanıcılar
            <span class="right" style="padding:4px;"><?php echo form_open(base_url().url_title($this->meslekname)."/admin/kullanicilar/", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #666666; padding:4px; width:214px; font-size:11px;" placeholder="Kullanıcılarda arama yapın"/>         
        <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
        <?php echo form_close() ?></span>
        </div>
        
    
    <table width="100%" cellpadding="6" cellspacing="0" class="display">
        <thead>
        <tr>
            <th width="40">Üye Resmi</th>
            <th>Adı Soyadı</th>
            <th>Üyelik Tarihi</th>
            <th>E-Mail Adresi</th>
            <th>Hesap Durumu</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <? $i=0; foreach($kullanicilar as $kullanici):  $i++; ?>
        <tr <?=($i%2) ?  "" : "bgcolor='#F7F7F7'" ?>>
            <td>
                <?
                if($kullanici->image!="" && file_exists("public/images/user/".$kullanici->id."/thumb1/".$kullanici->image."")){
                    echo "<img class='ttip' title='".$kullanici->adsoyad."' style=' border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/user/".$kullanici->id."/thumb1/".$kullanici->image."'>";
                } else {
                    echo "<img class='ttip' style='border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/user.jpg'>";
                }
                ?>
            </td>
            <td><b style="color:#2F547E"><?=$kullanici->adsoyad?></b></td>
            <td><?=dateFormat($kullanici->savedate)?></td>
            <td><?=$kullanici->email?></td>
            <td><?=($kullanici->active==1) ? "<img src='images/icons/tick-shield.png'> Aktif" : "<img src='images/icons/cross-shield.png'> Pasif"?></td>
            <td>
                <a href="<?=base_url().url_title($this->meslekname)?>/admin/kullanicilar/duzenle/<?=$kullanici->id?>?token=<?=setToken($kullanici->id."users")?>"><img src="images/icons/bookmark--pencil.png"/></a>
                <a href="javascript:void(0)" onclick="itemDelete('<?=$kullanici->id?>','<?=setToken($kullanici->id."users")?>')"><img src="images/icons/cross-circle-frame.png"/></a>
            </td>
        </tr>
        <? endforeach; ?>
    </table>
    </div>
    <?php if (count($kullanicilar) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->mod_user_model->total_rows . "</b> " . lang("adet") . " " . lang("üye kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->mod_user_model->total_rows;
                    $config['per_page'] = 20;
                    $config['query_string_segment'] = "s";


                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>
    
    
</div>
