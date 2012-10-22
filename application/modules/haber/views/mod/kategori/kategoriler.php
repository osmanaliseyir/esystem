<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
?>
<script type="text/javascript">
   
  function itemDelete(id,token){
      var u=confirm('<?php echo lang("Seçmiş olduğunuz kategoriyi silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/haberler/kategoriler/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz kategori silinmiştir.") ?> "));
               setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/haberler/kategoriler'",2000);

            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz kategori silinemedi!") ?>"));
            }
         }
      }); 
      }
   }

</script>
<div id="leftPanel">
   <? require APPPATH.'blocks/admin_yetki.php';  ?>
</div>
<div id="rightPanel">
   <div id="result"></div>
   <div class="block">
      <div class="head"><?php echo lang("Haber Kategorileri") ?></div>
      <table id="example" width="100%" class="display">
         <thead>
            <tr>
               <th><?php echo lang("Id") ?></th>
               <th><?php echo lang("İsim") ?></th>
               <th><?php echo lang("Açıklama") ?></th>
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
               <td><a href="<?php echo base_url().url_title($this->meslekname) ?>/admin/haberler/kategoriler/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id)?>"><img src="images/icons/bookmark--pencil.png"/></a></td>
               <td><a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/icons/cross-circle-frame.png"/></a></td>
            </tr>
            <? endforeach;?>
         </tbody>
      </table>
   </div>
</div>