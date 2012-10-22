<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>
<script type="text/javascript">
    function changeMansetItem(id){
        $(".manset_images div").css("display","none");
        $("#manset_image_"+id).css("display","block");
        $("#manset_image_"+id+" div" ).css("display","block");
    }

</script>
<div style="margin-top:10px; margin-left:10px;">
<div style="float:left; width:200px;">
    <img src="images/makale.png" style="vertical-align:bottom"/> <span style="font-size:18px; letter-spacing: -1px; font-weight: bold; color:#333333;">Makaleler</span>    
</div>
<div class="pageTitle" style="float:left; width:450px;">
    <ul>
        <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
        <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/makaleler">Makaleler</a></li>
    </ul>
</div>
<div style="float:left; width:280px;" align="right">
    <input type="input" style="border:1px solid #999999; padding:4px; width:280px; font-size:11px;" placeholder="Makale ve içeriklerinde arama yapın"/>    
</div>
    </div>
<div class="fix"></div>


<div id="leftPanel">
    <div class="block">
        <div class="head">Kategoriler</div>
        <? foreach($kategoriler as $kategori ):?>
         <div class="borderbottom" style="padding:8px;">
            <a href='<?=base_url().url_title($this->meslekname)?>/makaleler?category=<?=$kategori->id?>'><?=$kategori->name?></a>
            </div>
        <? endforeach; ?>
        
    </div>
    
    <? require APPPATH.'blocks/son_makaleler.php'; ?>
    <? require APPPATH.'blocks/cok_okunan_makaleler.php'; ?>
    
    

</div>
<div id="rightPanel">
    <? foreach($makaleler  as $makale): ?>
    <div style='padding-bottom:15px; margin-bottom:15px; line-height: 20px; font-size:13px;' class="borderbottom">
              <?
                if($makale->image!="" && file_exists("public/images/makale/thumb/".$makale->image."")){
                    echo "<img style='float:left; margin-right:8px; border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/makale/thumb/".$makale->image."'>";
                } else {
                    echo "<img style='float:left; margin-right:8px;border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/makale.jpg'>";
                }
                ?>
    <a style="font-size:18px; font-weight: bold;" href='<?=base_url().url_title($this->meslekname)?>/makaleler/<?=url_title($makale->name)?>-<?=$makale->id?>m.html'><?=$makale->name;?></a>
    <br/><div style='display:block; overflow: hidden; height: 60px;'><?=strip_tags($makale->subtitle); ?></div>
    <div style="padding:4px 0 0 0; font-size:11px;">
        <img src='images/icons/category.png' height="12"/> <?php echo $makale->categoryname ?>&nbsp;&nbsp;&nbsp;
        <img src="images/icons/calendar-small-month.png"/><?=dateFormat($makale->savedate,"long")?>&nbsp;&nbsp;&nbsp; 
        <img src="images/icons/flag--plus.png"  height="12"/>    Görüntülenme: <?=$makale->readnum?>
        </div>
    </div>
<? endforeach; ?>
    
    <?php if (count($makaleler) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->makale_model->total_rows . "</b> " . lang("adet") . " " . lang("makale kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->makale_model->total_rows;
                    $config['per_page'] = 20;
                    $config['query_string_segment'] = "s";
                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>
    
</div>