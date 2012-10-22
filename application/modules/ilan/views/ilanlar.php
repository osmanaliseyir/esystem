<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>

<script type="text/javascript">
function getIlces(id){
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>common/getIlcesJson',
         data: 'id='+id,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#ilce").html("");
               var html="";
               $.each(respond.data,function(key,value){
                 html+="<option value='"+value.id+"'>"+value.ad+"</option>";
               });
               $("#ilce").html(html);
            }else if (respond.success=="false") {
            }
         }
      }); 
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
    
    
    <div class="block">
        <div class="head">Detaylı Arama</div>
        <form action="<?=base_url().url_title($this->meslekname)?>/ilanlar">
        <table width="100%" class="formTable" cellpadding="5" cellspacing="0">
            <tr>
                <td><label for="il" style=" display: block;">İlan İli</label>
                <?=  form_dropdown("il",$iller,(isset($_GET["il"])) ? $_GET["il"] : "","onchange='getIlces(this.value)' style='width:180px;'")?></td>
            </tr>
            <tr>
                <td><label for="ilce" style=" display: block;">İlan İlçesi</label>
                <?=  form_dropdown("ilce",array(""=>"İl Seçmelisiniz"),(isset($_GET["ilce"])) ? $_GET["ilce"] : "","id='ilce' style='width:180px;'")?></td>
            </tr>
            <tr>
                <td><label for="ilantarihi" style=" display: block;">İlan Tarihi</label>
                <?=  form_dropdown("ilantarihi",array(""=>"Tümü","1"=>"Son 24 Saat içinde","2"=>"Son 3 Gün içinde","3"=>"Son 7 Gün içinde","4"=>"Son 15 Gün içinde","5"=>"Son 30 gün içinde"),(isset($_GET["ilantarihi"])) ? $_GET["ilantarihi"] : "","id='ilantarihi' style='width:180px;'")?></td>
            </tr>
            <tr>
                <td><label for="q" style=" display: block;">İlan Başlığı-İçeriği</label>
                <?=  form_input(array("name"=>"q","style"=>"width:180px;","value"=>(isset($_GET["q"])) ? $_GET["q"] : ""))?></td>
            </tr>
            <tr>
                <td><button class="button" onclick="this.form.Submit()">Detaylı Arama</button></td>
            </tr>
        </table>
            </form>
    </div>
    
    
</div>
<div id="rightPanel" style="width:760px;">

    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/ilanlar">İlanlar</a></li>
        </ul>
    </div>
  
    <div id="result" style="margin-top:5px;"></div>
    <div style="margin-top:10px;">

        
        <div class="block">
            <div class="head">İlanlar
            <span class="right" style="padding:3px;">
                 <?php echo form_open(base_url().url_title($this->meslekname)."/ilanlar/", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
                <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #999999; padding:4px; width:214px; font-size:11px;" placeholder="İlanlarda arama yapın"/>         
                <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
                <?php echo form_close() ?>
            </span>
            </div>
            
        
        
        
            <? if (count($ilanlar) > 0) { ?>
                <table class="display" width="100%" cellpadding="6" cellspacing="0" style="border-top:1px solid #EEEEEE;">
                    <thead>
                        <tr>
                            <th>İlan Başlığı</th>
                            <th>İlan Kategorisi</th>
                            <th>İlan Tarihi</th>
                            <th>İlan İl/İlçesi</th>
                        </tr>
                    </thead>
                    <?php $i=0; foreach ($ilanlar as $ilan): $i++; ?>
                        <tr <?=($i%2) ? "bgcolor='#F7F7F7'" :""?>>
                            <td height="42" width="60%"><b><a style="color:#376598" href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar/<?= url_title($ilan->name) ?>-<?= $ilan->id ?>i.html"><?= $ilan->name ?></b></td>
                            <td width="15%" style="font-size:11px;"><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar?category=<?= $ilan->category ?>"><?= $ilan->categoryname ?></a></td>
                            <td width="14%" style="font-size:11px;"><?= dateFormat($ilan->savedate) ?></td>
                            <td width="15%" style="font-size:11px;" align="center"><?=$ilan->ilname." <br> ".$ilan->ilcename?></td>
                        </tr>
                    <? endforeach; ?>


                </table><? } else { ?> 
                <div class="warning"><?php echo lang("Aradığınız Kriterlere Uyan İlan Kaydı Bulunamadı!") ?></div>
            <? } ?>
        </div>

        <?php if (count($ilanlar) > 0) { ?>
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
