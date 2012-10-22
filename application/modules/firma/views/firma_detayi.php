<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?=$this->config->item("GOOGLEMAPAPI")?>&sensor=true"></script>
<script type="text/javascript">
 var pageUrl='<?=base_url()?>';
 
 <? 
 if(isset($data->coordinats) && $data->coordinats!=""){
     
    if(isset($data->coordinats) && $data->coordinats!=""){
    $koordinat=explode(",",$data->coordinats);
    $koordinatx=$koordinat[0];
    $koordinaty=$koordinat[1];
}
     
        ?>
           
    function ilandetailMap(){
		var myOptions = {
			  center: new google.maps.LatLng(<?=$koordinatx?>,<?=$koordinaty?>),
			  zoom: 15,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map"),myOptions);
			
			var myLatlng = new google.maps.LatLng(<?=$koordinatx?>,<?=$koordinaty?>);
			var marker = new google.maps.Marker({
				  position: myLatlng,
				  map: map
			 });
    }
    
     $(document).ready(function(){
         ilandetailMap();
     });
    
   <?
    }else {?>
       $(document).ready(function(){
           $("#map").css("height","40px");
           $("#map").html("<div class='warning'><?=lang("Bu firmaya ait harita koordinatları eklenmediğinden dolayı konumu gösterilemiyor..")?></div>")
        });
        <?
    }
 
 ?>
 
$(function() {
        $('#gallery a').lightBox();
    });
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-lightbox/jquery.lightbox-0.5.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-lightbox/jquery.lightbox-0.5.min.js"></script>




<div id="leftPanel" style="width:760px;">
    
    
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/firmalar">Firmalar</a></li>
            <li><a href="<?=base_url()?><?= url_title($this->meslekname) ?>/firmalar?category=<?=$data->category?>"><?=$data->categoryname?></a></li>
        </ul>
    </div>
      
     <div style="width:320px; float: left;">
        <div style="padding:10px;">
<?
if ($data->logo!="" && file_exists("public/images/firma/" . $data->logo . "")) {
    echo "<img width='300' style='padding:2px; float:left; margin-right:5px; border:2px solid #CCCCCC;' src='" . base_url() . "public/images/firma/" . $data->logo . "'>";
} else {
    echo "<img width='300' style='padding:2px; float:left; margin-right:5px; border:2px solid #CCCCCC;' src='" . base_url() . "public/images/firma_logo_big.jpg'>";
}
?>
            <div class="fix" style="margin-bottom:5px;"></div>
            <div id="gallery">
            <?
                  if (count($photos) > 0) {

                     foreach ($photos as $val) {
                        echo "<div id='photo_" . $val->id . "' style='padding:3px; position:relative; border:1px solid #EEEEEE; margin-right:8px; margin-bottom:8px; float:left;'>";
                        echo "<a href='".base_url()."public/images/firma/" . $data->id . "/" . $val->url . "'><img width='84' height='55' src='" . base_url() . "public/images/firma/" . $data->id . "/thumb/" . $val->url . "'></a><br>";
                        echo "</div>";
                     }
                  }
                  ?>
            
        </div>
        </div>
        
        
        
    </div>

    <div style="padding:10px; float:left; width:400px;">
        <table width="100%" cellpadding="5" cellspacing="0">
            <tr>
                <td colspan="2" class="borderbottom"><span style="display:block; padding:0 5px 5px 0; font-size:18px; font-family: Arial; color:#016CA7; font-weight: bold;"><?php echo $data->name ?></span></td>
            </tr>
            <tr>
                <td width="40%" class="borderbottom"><img src='images/category.png'/> <span style='color:#333333;'><b><?php echo lang("Firma Kategorisi") ?>:</b></span></td>
                <td class="borderbottom"><a href="<?=base_url()?>firmalar?category=<?=$data->category?>"><?php echo $data->categoryname ?></td>
            </tr>
            <tr>
                <td width="40%" class="borderbottom"><img src='images/map-pin.png'/> <span style='color:#333333;'><b><?php echo lang("Firma İl/İlçesi") ?>:</b></span></td>
                <td class="borderbottom"><?php echo $data->il ?> / <?php echo $data->ilce ?></td>
            </tr>
            <tr>
                <td class="borderbottom"><img src='images/telephone.png'/> <span style='color:#333333;'><b><?php echo lang("Firma Telefonu") ?>:</b></span></td>
                <td class="borderbottom"><?php echo $data->sabittel; ?></td>
            </tr>
            <tr>
                <td class="borderbottom"><img src='images/mobile-phone-cast.png'/> <span style='color:#333333;'><b><?php echo lang("Firma Cep Telefonu") ?>:</b></span></td>
                <td class="borderbottom"><?php echo $data->ceptel; ?></td>
            </tr>
            <tr>
                <td class="borderbottom"><img src='images/telephone--arrow.png'/> <span style='color:#333333;'><b><?php echo lang("Firma Faksı") ?>:</b></span></td>
                <td class="borderbottom"><?php echo $data->faks; ?></td>
            </tr>
            <tr>
                <td class="borderbottom"><img src='images/mail--arrow.png'/> <span style='color:#333333;'><b><?php echo lang("Firma E-Posta Adresi") ?>:</b></span></td>
                <td class="borderbottom"><?php echo $data->email; ?></td>
            </tr>
            <tr>
                <td class="borderbottom"><img src='images/address-book-blue.png'/> <span style='color:#333333;'><b><?php echo lang("Firma Adresi") ?>:</b></span></td>
                <td class="borderbottom"><?php echo $data->adres; ?></td>
            </tr>
            <tr height="50">
                <td colspan="2" class="borderbottom">
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                        <a class="addthis_button_preferred_1"></a>
                        <a class="addthis_button_preferred_2"></a>
                        <a class="addthis_button_preferred_3"></a>
                        <a class="addthis_button_preferred_4"></a>
                        <a class="addthis_button_compact"></a>
                        <a class="addthis_counter addthis_bubble_style"></a>
                    </div>
                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f5bd5533ef93705"></script>
                    <!-- AddThis Button END -->

                </td>
            </tr>
            <tr>
                <td class="borderbottom" ><img src="images/arrow.png"/> <span style='color:#666666;'><?php echo lang("Firma Kayıt Tarihi") ?>:</span></td>
                <td class="borderbottom"><?php echo dateFormat($data->savedate) ?></td>
            </tr>
            <tr>
                <td class="borderbottom"><img src="images/arrow.png"/> <span style='color:#666666;'><?php echo lang("Firma Güncelleme Tarihi") ?>:</span></td>
                <td class="borderbottom"><?php echo dateFormat($data->updatedate) ?></td>
            </tr>
        </table>

    </div>
    <div style="padding:10px">
        <div class="block">
            <div class="head"><h3><?php echo lang("Firma Açıklaması") ?></h3></div>
            <div style="padding:10px; font-size:14px; color:#000000; line-height: 25px;">
<?php echo $data->description ?>
            </div>
        </div>

        <div class="block" style="margin-top:10px;">
            <div class="head"><h3><?= lang("Harita Üzerindeki Yeri") ?></h3></div>
            <div id="map" style="width:762px; height:300px;"></div>
            
            
        </div>
        
        <div class="block" style="margin-top:10px;">
            <div class="head"><h3><?= lang("Firmaya Ait İlanlar") ?></h3></div>


            <table width="100%" cellpadding="5" cellspacing="0">
<? foreach ($firmailanlari as $ilan): ?>
                    <tr>
                    <td class="borderbottom" height="40" width="50%"><b><a style="color:#376598" href="<?=base_url()?>ilanlar/detay/<?=$ilan->id?>"><?=$ilan->name?></b></td>
                    <td class="borderbottom" width="15%"><a href="<?=base_url()?>ilanlar?category=<?=$ilan->category?>"><?=$ilan->categoryname?></a></td>
                    <td class="borderbottom" width="15%"><?= dateFormat($ilan->savedate,'long')?></td>
                </tr>
<? endforeach; ?>
            </table>
        </div></div>

</div>
<div id="rightPanel" style="width:200px;">
    <div class="itemTitle">Sponsor Firmalar</div>
   

</div>
