<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

$this->load->helper(array("form", "date"));
?>
<script type="text/javascript">
    

</script>
<div id="leftPanel" style="width:970px;">
    <div style="float:left; width:200px;">
        <img src="images/globe.png" style="vertical-align:bottom"/> <span style="font-size:18px; letter-spacing: -1px; font-weight: bold; color:#333333;">Makaleler</span>    
    </div>
    <div class="pageTitle" style=" float:left; width:418px;">
        <ul>
            <li><a href="<?= base_url() . $this->uri->segment(1) ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() . $this->uri->segment(1) ?>/makaleler">Makaleler</a></li>
        </ul>
    </div>
    <div style="float:left; width:260px;" align="right">
        <input type="input" style="border:1px solid #999999; padding:4px; width:314px; font-size:11px;" placeholder="Makale ve içeriklerinde arama yapın"/>    
    </div>
    <div style="clear: both;"></div>

    <div style="margin-top: 10px; padding-top: 10px; border-top:1px solid #CCCCCC;">
        <div style="float:left; width:658px; margin-right: 10px;">
            <?
        if ($data->image != "" && file_exists("public/images/makale/thumb2/" . $data->image . "")) {
            echo "<img style='margin-right: 10px; margin-bottom:10px; float:left; border:2px solid #CCCCCC; padding:2px;' src='" . base_url() . "public/images/makale/thumb2/" . $data->image . "'>";
        }
        ?>

        <h2><?= $data->name ?></h2>
        <div style="padding:10px 0;" class="borderbottom">
            <span style="color:#666666; font-size:11px;"><img src='images/icons/calendar-day.png'> <?= dateFormat($data->savedate, "long") ?></span>&nbsp;&nbsp;&nbsp; 
            <span style="color:#666666; font-size:11px;"><img src='images/icons/sort-date-descending.png'> <?= $data->readnum ?> Okunma</span>&nbsp;&nbsp;&nbsp;
            <span style="color:#666666; font-size:11px;"><img src='images/icons/category.png'> <?= $data->categoryname?></span>
        </div>
      
        <div style="line-height: 24px; font-size:14px; font-weight: bold; margin:10px 0;"><?= $data->subtitle ?></div>
        <div style="line-height: 24px; font-size:14px;"><?= $data->description ?></div>
        
        <? // Yorum ?>
        
        <? 
        if($this->session->userdata("user_id")!=""){
            ?><table width="100%" cellpadding="4" cellspacing="0" class="formTable" style="font-size:11px;">
                 <tr>
                     <td colspan="2"><h5>Yorum Yap</h5><div id="comment-result"></div></td>
                </tr>
                <tr>
                    <td width="120"><label for="comment-title">Yorum Başlığı</label></td>
                    <td><?php echo form_input(array("name"=>"comment-title","id"=>"comment-title","style"=>"width:500px;"))?></td>
                </tr>
                <tr>
                    <td valign="top"><label for="comment-title">Açıklama</label></td>
                    <td><?php echo form_textarea(array("name"=>"comment-desc","id"=>"comment-desc","style"=>"width:500px; height:40px;"))?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo form_button(array("content"=>"Kaydet","name"=>"kaydet","onclick"=>"kaydet()")) ?></td>
                </tr>
            </table>
         
            <?
        }else {
            echo "<div class='warning'>Yorum Yapabilmek için giriş yapmanız gerekmektedir. Üye iseniz <a href='".base_url()."login'>giriş yapın.</a> Değilseniz üye olmak için <a href='".base_url()."signup'>tıklayın.</a></div>";
        }
        ?>
        
        
        
        
        </div>
        
        
        
        <div style="float:left; width: 300px;">
            <? require APPPATH.'blocks/admin_yetki.php'; ?>
            <? require APPPATH.'blocks/son_makaleler.php'; ?>
            <? require APPPATH.'blocks/cok_okunan_makaleler.php'; ?>
        </div>

        


        <div class="fix"></div>
    </div>
</div>

