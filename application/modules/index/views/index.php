<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>

    <div id="leftPanel" style="width:660px;">
    <? require APPPATH . 'blocks/manset_haberler.php' ?>
</div>



<div id="rightPanel" style="width:300px;">
    <? require APPPATH . "blocks/istatistikler.php" ?>   
    <? require APPPATH . 'blocks/son_haberler.php' ?>
    <? require APPPATH . 'blocks/forumdan_son_konular.php' ?>
        <? require APPPATH . 'blocks/meslek_secimi.php' ?>

</div>
<div style="clear:both"></div>
