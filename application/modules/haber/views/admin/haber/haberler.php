<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
   $this->load->helper("date");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.js"></script>
<script type="text/javascript">
   
   $(function(){
      var table=$("#example").dataTable({
      sPaginationType:'full_numbers',
      aoColumnDefs:[{
         bSortable:false,
         aTargets:[4,5]
         }],
     aaSorting:[[0,"desc"]]
   });
   });

   function itemDelete(id,token){
      var table=$("#example").dataTable();
      var u=confirm('<?php echo lang("Seçmiş olduğunuz haberi silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/haber/haberler/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz haber silinmiştir.") ?> "));
               var position=table.fnGetPosition($("#row_"+id)[0]);
               table.fnDeleteRow(position);
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz haber silinemedi!") ?>"));
            }
         }
      }); 
      }
   }

</script>
<div id="leftPanel">
    <div class="block">
        <div class="head"><h3><?php echo  lang("Haber İşlemleri") ?></h3></div>
        <ul class="listMenu">
            <li><a href="<?=base_url()?>admin/haber/haberler/add"><?=lang("Haber Ekle")?></a></li>
            <li><a href="<?=base_url()?>admin/haber/haberler/"><?=lang("Haberler")?></a></li>
        </ul>
    </div>
</div>
<div id="centerPanel" style="width:786px;">
   <div id="result"></div>
   <div class="block">
      <div class="head"><h3><?php echo lang("Haberler") ?></h3></div>
      <table id="example" width="100%" class="display">
         <thead>
            <tr>
               <th><?php echo lang("Id") ?></th>
               <th><?php echo lang("İsim") ?></th>
               <th><?php echo lang("Kategori") ?></th>
               <th><?php echo lang("Kaydetme Tarihi") ?></th>
               <th width="2%"></th>
               <th width="2%"></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($data as $row) :  ?>
            <tr id="row_<?php echo $row->id ?>">
               <td><?php echo $row->id ?></td>
               <td><b><?php echo $row->name ?></b></td>
               <td><?php echo $row->categoryname ?></td>
               <td><?php echo dateFormat($row->savedate,'long')?></td>
               <td><a href="<?php echo base_url() ?>admin/haber/haberler/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id)?>"><img src="images/edit.png"/></a></td>
               <td><a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/delete.png"/></a></td>
            </tr>
            <? endforeach;?>
         </tbody>
      </table>
   </div>
</div>