<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>

<script type="text/javascript">
    function ilanIslem(id, islem){
        var metin;
        if(islem == 1){
            metin = "Onaylamak istediğinizden emin misiniz?";
        }else{
            metin = "İlanı silmek istediğinizden emin misiniz?";
        }
        var dogrula = confirm(metin);
        if(dogrula == 1){
            $("#result").html(resultFormat('pending','İşleminiz yapılıyor...'));
            $.ajax({
                type    : 'POST',
                url     : '<?= base_url() ?>'+'<?=url_title($this->meslekname)?>'+'/admin/ilanlar/ilanOnaylaReddet',
                data    : 'id='+id+'&active='+islem+'&islemYapanID=<?=$this->session->userdata("user_id")?>',
                dataType: 'json',
                success : function(respond){
                    if(respond.success == "true"){
                        $("#result").html(resultFormat('success','İşleminiz yapıldı!'));
                    }else{
                        $("#result").html(resultFormat('alert','Bir hata oluştu!..'));
                    }
                },
                error   : function(respond){
                    $("#result").html(resultFormat('alert','Bir hata oluştu!..'));
                },
                complete: function(){
                    setTimeout(window.location.reload,1000);
                }
            });
        }
    }
</script>

<div id="leftPanel">
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">
    
    
        <div id="result"></div>
    
        <div class="block">
            <div class="head">İlanlar
            
                 <span class="right" style="padding:4px;"><?php echo form_open(base_url().url_title($this->meslekname)."/admin/ilanlar/", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <?php echo form_dropdown("active",$this->durum,(isset($_GET["active"]))? $_GET["active"]: "" ) ?>
        <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #666666; padding:4px; width:214px; font-size:11px;" placeholder="İlanlarda arama yapın"/>         
        <input type="input" name="id" id="id" value="<?= isset($_GET["id"]) ? $_GET["id"] : "" ?>" style="border:1px solid #666666; padding:4px; width:80px; font-size:11px;" placeholder="İlan IDsi"/>         
        <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
        <?php echo form_close() ?></span>   
                
            </div>
                
       
            <? if (count($ilanlar) > 0) { ?>
                <table class="display" width="100%" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50%">İlan Başlığı</th>
                            <th width="15%">İlan Kategorisi</th>
                            <th width="15%">İlan Tarihi</th>
                            <th width="15%">İşlemler</th>
                        </tr>
                    </thead>
                    <?php foreach ($ilanlar as $ilan): ?>
                        <tr>
                            <td height="30" ><b><a style="color:#376598" class="ttip" title="<?=  nl2br($ilan->description)?>" href="<?=base_url().url_title($this->meslekname)?>/admin/ilanlar/editsave/<?=$ilan->id?>?token=<?=setToken($ilan->id."ilan")?>"><?= $ilan->name ?></b>
                                <br><a target="_blank" style="font-size:11px;" href="<?=base_url()."kullanici/".$ilan->user_id ?>"><?=$ilan->adsoyad?></a></td>
                            <td style="font-size:11px;"><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/admin/ilanlar?active=0&category=<?= $ilan->category ?>"><?= $ilan->categoryname ?></a></td>
                            <td style="font-size:11px; color:#666666;"><?=dateFormat($ilan->savedate, 'long') ?></td>
                            <td align="left"><a href="<?=base_url().url_title($this->meslekname)?>/admin/ilanlar/editsave/<?=$ilan->id?>?token=<?=setToken($ilan->id."ilan")?>"><img src="images/icons/blog--pencil.png" alt="Edit" /></a>
                            
                             <a onclick="ilanIslem(<?=$ilan->id?>,0);" href="javascript:void(0);"><img src="images/icons/cross.png" alt="Reddet" /></a>
                             <? 
                           echo ($ilan->active==0) ? ' <a onclick="ilanIslem('.$ilan->id.',1);" href="javascript:void(0);"><img src="images/icons/tick.png" alt="Onayla" /></a>' : '';
                            ?></td>
                        </tr>
                    <? endforeach; ?>
                </table>
                <? } else { ?> 
                <div class="warning"><?php echo lang("Aradığınız Kriterlere Uyan İlan Kaydı Bulunamadı!") ?></div>
            <? } ?>
        
     </div>
        
        
         <?php if (count($ilanlar) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->mod_ilan_model->total_rows . "</b> " . lang("adet") . " " . lang("ilan kaydı bulundu!") ?>
                </div>
                <div style="float:left; text-align: right; width:443px;">
                    <?php
                    $this->load->library('pagination');
                    $url = "";
                    $i = 0;
                    if (isset($_GET)) { foreach ($_GET as $k => $v) { $i++; if ($k != "s") $url.=$k . "=" . $v;  $url.=($i != count($_GET)) ? "&" : ""; }}
                    $config['prev_link'] = '&lt;' . lang("Önceki");
                    $config['next_link'] = lang("Sonraki") . '&gt;';
                    $config['page_query_string'] = true;
                    $config['base_url'] = base_url() . $this->uri->uri_string() . "?" . $url;
                    $config['total_rows'] = $this->mod_ilan_model->total_rows;
                    $config['per_page'] = 20;
                    $config['query_string_segment'] = "s";
                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>
    
        
</div>
