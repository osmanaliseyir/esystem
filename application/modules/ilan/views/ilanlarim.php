<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>

<script type="text/javascript">
 function itemDelete(id,token){
      var u=confirm('<?php echo lang("Seçmiş olduğunuz ilanı silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url().url_title($this->meslekname) ?>/ilanlar/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz ilan silinmiştir.") ?> "));
               setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/ilanlar/ilanlarim'",2000);

            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz ilan silinemedi!") ?>"));
            }
         }
      })
      }
   }

</script>

<div id="leftPanel" style="width:200px;">
     <div class="subMenu">
    <ul>
        <li><a href="<?=base_url().url_title($this->meslekname)?>/ilanlar/ilanlarim"><img src="images/icons/tickets.png"/> İlanlarım</a></li>
        <li><a href="<?=base_url().url_title($this->meslekname)?>/ilanlar/ekle"><img src="images/icons/ticket--plus.png"/> Yeni İlan Ekle</a></li>
    </ul>
    </div>
    
    <? // require APPPATH."blocks/admin_yetki.php" ?>
    <? require APPPATH."blocks/ilan_kategorileri.php" ?>
    
    
    
</div>
<div id="rightPanel" style="width:760px;">

    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/ilanlar/ilanlarim">İlanlarım</a></li>
        </ul>
    </div>
  
    <div id="result" style="margin-top:5px;"></div>
    <div style="margin-top:10px;">

        
        <div class="block">
            <div class="head">İlanlarım</div>
            
        
        
        
            <? if (count($ilanlarim) > 0) { ?>
                <table class="display" width="100%" cellpadding="6" cellspacing="0" style="border-top:1px solid #EEEEEE;">
                    <thead>
                        <tr>
                            <th>İlan Başlığı</th>
                            <th>İlan Kategorisi</th>
                            <th>İlan Tarihi</th>
                            <th>İlan İl/İlçesi</th>
                            <th>İlan Durumu</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <?php $i=0; foreach ($ilanlarim as $ilan): $i++; ?>
                        <tr <?=($i%2) ? "bgcolor='#F7F7F7'" :""?>>
                            <td height="30" width="50%"><b><a style="color:#376598" href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar/<?= url_title($ilan->name) ?>-<?= $ilan->id ?>i.html"><?= $ilan->name ?></b></td>
                            <td width="15%" style="font-size:11px;"><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar?category=<?= $ilan->category ?>"><?= $ilan->categoryname ?></a></td>
                            <td width="12%" style="font-size:11px;"><?= dateFormat($ilan->savedate, 'long') ?></td>
                            <td width="12%" style="font-size:11px;" align="center"><?=$ilan->ilname." <br> ".$ilan->ilcename?></td>
                            <td width="15%"><?=($ilan->active==1) ? "<img src='images/icons/tick-shield.png'> Aktif" : "<img src='images/icons/cross-shield.png'> Pasif"?></td>

                             <td><a href="<?php echo base_url().url_title($this->meslekname) ?>/ilanlar/edit/<?php echo $ilan->id ?>?token=<?php echo setToken($ilan->id)?>"><img src="images/icons/bookmark--pencil.png"/></a>
               <a href="javascript:void(0)" onclick="itemDelete('<?php echo $ilan->id ?>','<?php echo setToken($ilan->id); ?>')"><img src="images/icons/cross-circle-frame.png"/></a></td>
                        </tr>
                    <? endforeach; ?>


                </table><? } else { ?> 
                <div class="warning">Henüz ilanınınız bulunmamaktadır. Sitemizden ilan vermek ücretsizdir. Hemen şimdi ilanınızı verin. İlanınızı vermek için <a href="<?=base_url().url_title($this->meslekname)?>/ilanlar/ekle">tıklayınız!</a></div>
            <? } ?>
        </div>

        <?php if (count($ilanlarim) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->ilan_model->total_rows . "</b> " . lang("adet") . " " . lang("ilan kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->ilan_model->total_rows;
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
