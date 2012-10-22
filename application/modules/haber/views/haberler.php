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
    <img src="images/globe.png" style="vertical-align:bottom"/> <span style="font-size:18px; letter-spacing: -1px; font-weight: bold; color:#333333;">Haberler</span>    
</div>
<div class="pageTitle" style="float:left; width:450px;">
    <ul>
        <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
        <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/haberler">Haberler</a></li>
    </ul>
</div>
<div style="float:left; width:280px;" align="right">
    <input type="input" style="border:1px solid #999999; padding:4px; width:280px; font-size:11px;" placeholder="Haber ve içeriklerinde arama yapın"/>    
</div>
    </div>
<div class="fix"></div>


<div id="leftPanel" style="width:660px" >
<? require APPPATH . 'blocks/manset_haberler.php'; ?>
</div>
<div id="rightPanel" style="width:300px;">
<? require APPPATH . 'blocks/cok_okunan_haberler.php'; ?>
</div>