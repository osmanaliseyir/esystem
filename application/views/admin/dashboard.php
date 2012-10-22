<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
?>
<script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-slider/jcarousellite.js"></script>
<script type="text/javascript">
   $(function(){
      $(".slider").jCarouselLite({
         btnNext: ".next",
         btnPrev: ".prev",
         scroll:4,
         visible:4
      })
   });
</script>
<style>
   .slider {
      width:586px;
   }
   .slider ul li {
      height:100px;
      width:100px;
      border:1px solid #CCCCCC;
      margin:10px;
   }
</style>
<div id="leftPanel">
   <?php require APPPATH . 'modules/account/widgets/adminUserAccount.php'; ?>

</div>
<div id="centerPanel">
   <div class="block">
      <div class="head"><h3><?php echo lang("Duyurular") ?></h3></div>

   </div>
</div>

