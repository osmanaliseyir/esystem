<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');
   $this->load->helper(array("date","form"));
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<script type="text/javascript">
   
   function itemDelete(id,token){
      var u=confirm('<?php echo lang("Seçmiş olduğunuz forumu silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/forum/forumlar/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz forum silinmiştir.") ?> "));
               setTimeout("window.location='<?=base_url()?>admin/forum/forumlar'",2000);
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz forum silinemedi!") ?>"));
            }
         }
      }); 
      }
   }
  
    function selectedDelete(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/forum/forumlar/deleteSelected/',
                data:$("#itemForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet forum silinmiştir.") ?> "));
                        setTimeout("window.location='<?=base_url()?>admin/forum/forumlar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
</script>
<div id="centerPanel" style="width:990px;">
    
    
    
   <div id="result"></div>
 
           <div id="search" style="padding:14px 10px 5px 10px">
            <?php echo form_open(base_url() . "admin/forum/forumlar/", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
            <?php echo form_input(array("name" => "q", "id" => "q", "style" => "width:300px;","value"=>(isset($_GET["q"])) ? $_GET["q"] : "")); ?>
            <?php echo form_dropdown("meslek",$meslekler,(isset($_GET["meslek"])) ? $_GET["meslek"] : ""); ?>
            <?php echo form_button(array("content" => lang("Arama"), "class" => "smallblue", "onclick" => "$('#searchForm').submit()")) ?>
            <?php echo form_close() ?>
           </div>
   <div class="block">
      <div class="head"><h3><?php echo lang("Forumlar") ?></h3></div>
      <? echo form_open("",array("id"=>"itemForm","name"=>"itemForm")) ?>
      <input type="hidden" name="checkVal" id="checkVal" value="0"/>
        <table id="example" width="100%" class="display">
         <thead>
            <tr>
               <th width="2%"></th>
               <th><?php echo lang("Forum Adı") ?></th>
               <th><?php echo lang("Meslek") ?></th>
               <th><?php echo lang("Kayıt Tarihi") ?></th>
               <th width="2%"></th>
               <th width="2%"></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($data as $row) :  ?>
            <tr id="row_<?php echo $row->id ?>">
               <td><input type="checkbox" name="sec[]" value="<?=$row->id?>"/></td>
               <td><?php echo $row->name ?></td>
               <td><?php echo $meslekler[$row->meslek_id]?></td>
               <td><?php echo dateFormat($row->savedate,"long")?></td>
               <td><a href="<?php echo base_url() ?>admin/forum/forumlar/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id)?>">Düzenle</a></td>
               <td><a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/delete.png"/></a></td>
            </tr>
            <? endforeach;?>
         </tbody>
      </table>
      <? echo form_close() ?>
      <?php if (count($data) > 0) { ?>
            <div id="pagination" style="padding:10px;">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->admin_forum_model->total_rows . "</b> " . lang("adet") . " " . lang("kayıt bulundu!") ?>
                </div>
                <div style="float:left; text-align: right; width:770px;">
                    <?php
                    $this->load->library('pagination');
                    $url = "";
                    $i = 0;
                    if (isset($_GET)) {
                        foreach ($_GET as $k => $v) {
                            $i++;
                            if ($k != "s")
                                $url.=$k . "=" . $v;
                            $url.=($i != count($_GET)) ? "&" : "";
                        }
                    }

                    $config['prev_link'] = '&lt;' . lang("Önceki");
                    $config['next_link'] = lang("Sonraki") . '&gt;';
                    $config['page_query_string'] = true;
                    $config['base_url'] = base_url() . $this->uri->uri_string() . "?" . $url;
                    $config['total_rows'] = $this->admin_forum_model->total_rows;
                    $config['per_page'] = 20;
                    $config['query_string_segment'] = "s";

                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
      <div style=" margin:10px;" style="">
            <?php echo form_button(array("content"=>lang("Tümünü Seç"),"class"=>"blue","onclick"=>"checkAll()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Sil"),"class"=>"blue","onclick"=>"selectedDelete()"))?>
        </div>
        <div class="fix"></div>
        <? } ?>

      
   </div>
</div>