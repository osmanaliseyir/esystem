<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-plotchart/jquery.charts.css"/>
<script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-plotchart/excanvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-plotchart/jquery.charts.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.js"></script>
<script type="text/javascript">
   $(function(){
      userDayIst();
      $("#table").dataTable({
       sPaginationType:'full_numbers',
       aaSorting:[[0,"desc"]] 
      });
   });
   
   function showTooltip(x, y, contents) {
      $('<div id="tooltip">' + contents + '</div>').css( {
         position: 'absolute',
         display: 'none',
         top: y + 5,
         left: x + 5,
         border: '1px solid #fdd',
         padding: '2px',
         'background-color': '#fee',
         opacity: 0.80
      }).appendTo("body").fadeIn(200);
   }

   function userDayIst(){
      $.ajax({
         url: "<?php echo base_url() ?>admin/stats/users/getMonthStats",
         method: 'GET',
         dataType: 'json',
         success: function(respond){
            var data=respond.result;
            var options = {
               lines: {show: true},
               points: {show: true,radius:4},
               xaxis: {tickDecimals: 0, tickSize: 1},
               grid: {clickable: true}
            };
            $.plot($("#chart"), data, options);
            
            var previousPoint = null;
            $("#chart").bind("plotclick", function (event, pos, item) {
               $("#x").text(pos.x.toFixed(2));
               $("#y").text(pos.y.toFixed(2));
               if (item) {
                  if (previousPoint != item.dataIndex) {
                     previousPoint = item.dataIndex;

                     $("#tooltip").remove();
                     showTooltip(item.pageX, item.pageY,item.datapoint[1]+" "+lang["Ziyaretçi"]);
                  }
               }
               else {
                  $("#tooltip").remove();
                  previousPoint = null;            
               }
            });
         }
      });
   }
   
</script>
<div id="leftPanel">
   <div class="block">
      <div class="head"><h3><?php echo lang("Kullanıcı İstatistikleri") ?></h3></div>
      <ul class="listMenu">
         <li><a href="<?php echo base_url() ?>admin/stats/users/day"><?php echo lang("Günlük İstatistikler") ?></a></li>
         <li><a href="<?php echo base_url() ?>admin/stats/users/month"><?php echo lang("Aylık İstatistikler") ?></a></li>
         <li><a href="<?php echo base_url() ?>admin/stats/users/year"><?php echo lang("Yıllık İstatistikler") ?></a></li>
      </ul>
   </div>
</div>
<div id="centerPanel" style="width:786px;">
   <div class="block">
      <div class="head"><h3><?php echo lang("Aylık İstatistikler") ?></h3></div>
      <div style="padding:10px;">
         <div id="chart" style=" width:747px; height:200px;"></div>
      </div>

   </div>
   <div class="block" style="margin-top:5px;">
      <div class="head"><h3><?php echo lang("Aylık İstatistikler") ?></h3></div>
      <table id="table" width="100%" cellpadding="4" cellspacing="0" class="display">
         <thead>
            <tr>
               <th><?php echo lang("Ay") ?></th>
               <th><?php echo lang("Yıl") ?></th>
               <th><?php echo lang("Tekil Ziyaretçi") ?></th>
               <th><?php echo lang("Çoğul Ziyaretçi") ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($data as $row) : ?>
               <tr>
                  <td><?php echo $row["ay"] ?></td>
                  <td><?php echo $row["yil"] ?></td>
                  <td><?php echo $row["tekil"] ?></td>
                  <td><?php echo $row["cogul"] ?></td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</div>
