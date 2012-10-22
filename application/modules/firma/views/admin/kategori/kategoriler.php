<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
?>
<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
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
         }]
   });
   });

   function itemDelete(id,token){
      var table=$("#example").dataTable();
      var u=confirm('<?php echo lang("Seçmiş olduğunuz kategoriyi silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/firma/category/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz kategori silinmiştir.") ?> "));
               var position=table.fnGetPosition($("#row_"+id)[0]);
               table.fnDeleteRow(position);
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz kategori silinemedi!") ?>"));
            }
         }
      }); 
      }
   }

</script>
<div id="leftPanel">
   <div class="block">
      <div class="head"><h3><?php echo lang("Firma Kategori İşlemleri") ?></h3></div>
      <ul class="listMenu">
         <li><a href="<?php echo base_url() ?>admin/firma/category/add"><?php echo lang("Yeni Kategori ekle") ?></a></li>
         <li><a href="<?php echo base_url() ?>admin/firma/category"><?php echo lang("Firma Kategorileri") ?></a></li>
      </ul>
   </div>
</div>
<div id="centerPanel" style="width:786px;">
   <div id="result"></div>
   <div class="block">
      <div class="head"><h3><?php echo lang("Firma Kategorileri") ?></h3></div>
      <table id="example" width="100%" class="display">
         <thead>
            <tr>
               <th><?php echo lang("Id") ?></th>
               <th><?php echo lang("İsim") ?></th>
               <th><?php echo lang("Açıklama") ?></th>
               <th><?php echo lang("Üst Kategorisi") ?></th>
               <th width="2%"></th>
               <th width="2%"></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($data as $row) :  ?>
            <tr id="row_<?php echo $row->id ?>">
               <td><?php echo $row->id ?></td>
               <td><?php echo $row->name ?></td>
               <td><?php echo $row->description ?></td>
               <td><?php echo ($row->parent=="0") ? lang("Ana Kategori") : $row->parentname  ?></td>
               <td><a href="<?php echo base_url() ?>admin/firma/category/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id)?>"><img src="images/edit.png"/></a></td>
               <td><a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/delete.png"/></a></td>
            </tr>
            <? endforeach;?>
         </tbody>
      </table>
   </div>
</div>