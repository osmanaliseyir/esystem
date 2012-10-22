<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
   $this->load->helper(array("date","form"));
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<script type="text/javascript">
   
   function itemDelete(id,token){
      var u=confirm('<?php echo lang("Seçmiş olduğunuz firmayı silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>admin/firma/firmalar/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz firma silinmiştir.") ?> "));
               setTimeout("window.location='<?=base_url()?>admin/firma/firmalar'",2000);
            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz firma silinemedi!") ?>"));
            }
         }
      }); 
      }
   }
   
   function selectedActive(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/firma/firmalar/active/',
                data:$("#firmaForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet firma aktifleştirilmiştir.") ?> "));
                         setTimeout("window.location='<?=base_url()?>admin/firma/firmalar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
    
    function selectedPasive(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/firma/firmalar/pasive/',
                data:$("#firmaForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet firma pasifleştirilmiştir.") ?> "));
                         setTimeout("window.location='<?=base_url()?>admin/firma/firmalar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
    
    function selectedDelete(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/firma/firmalar/deleteSelected/',
                data:$("#firmaForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet firma silinmiştir.") ?> "));
                        setTimeout("window.location='<?=base_url()?>admin/firma/firmalar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
    
    function gozde(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/firma/firmalar/gozde/',
                data:$("#firmaForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet firma gözde firma olarak işaretlendi.") ?> "));
                        setTimeout("window.location='<?=base_url()?>admin/firma/firmalar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
    
    function normal(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/firma/firmalar/normal/',
                data:$("#firmaForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet firma gözde firmalardan çıkartıldı.") ?> "));
                        setTimeout("window.location='<?=base_url()?>admin/firma/firmalar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }

</script>
<div id="centerPanel" style="width:990px;">
    
    
    
   <div id="result"></div>
   <div class="block">
       <div class="head"><h3><?= lang("Filtreleme") ?></h3></div>
           <div id="search" style="padding:14px 10px 5px 10px">
            <?php echo form_open(base_url() . "admin/firma/firmalar/detayliarama", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
            <?php echo form_input(array("name" => "q", "id" => "q", "style" => "width:300px;","value"=>(isset($_GET["q"])) ? $_GET["q"] : "")); ?>
            <?php echo form_dropdown("category", $categoryDropdown, (isset($_GET["category"]))? $_GET["category"] : "", "id='category' style='padding:2px; width:200px;'"); ?>
            <?php echo form_dropdown("active", array(""=>lang("Tümü"),"1"=>lang("Aktif"),"0"=>lang("Pasif")), (isset($_GET["active"]))? $_GET["active"] : "", "id='active' style='padding:2px;'"); ?>
            <?php echo form_button(array("content" => lang("Arama"), "class" => "smallblue", "onclick" => "$('#searchForm').submit()")) ?>
            <?php echo form_close() ?>
        </div>
   </div>
   <div class="block">
      <div class="head"><h3><?php echo lang("Firmalar") ?></h3></div>
      <? echo form_open("",array("id"=>"firmaForm","name"=>"firmaForm")) ?>
      <input type="hidden" name="checkVal" id="checkVal" value="0"/>
        <table id="example" width="100%" class="display">
         <thead>
            <tr>
               <th width="2%"></th>
               <th width="2%"><?php echo lang("Id") ?></th>
               <th><?php echo lang("İsim") ?></th>
               <th><?php echo lang("Kategori") ?></th>
               <th><?php echo lang("İl")."/".lang("İlçe") ?></th>
               <th><?php echo lang("Kaydetme Tarihi") ?></th>
               <th><?php echo lang("Durumu") ?></th>
               <th width="2%"></th>
               <th width="2%"></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($firmalar as $row) :  ?>
            <tr id="row_<?php echo $row->id ?>">
               <td><input type="checkbox" name="sec[]" value="<?=$row->id?>"/></td>
               <td><?php echo $row->id ?></td>
               <td><b><?php echo $row->name ?></b><span style="color:#999999"><br/><?php echo $row->adsoyad ?></span></td>
               <td><?php echo $row->categoryname ?></td>
               <td><?php echo $row->il.",".$row->ilce ?></td>
               <td><?php echo dateFormat($row->savedate,'long')?></td>
               <td><?=($row->active=="1") ? lang("Aktif"): lang("Pasif")?></td>
               <td><a href="<?php echo base_url() ?>admin/firma/firmalar/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id)?>"><img src="images/edit.png"/></a></td>
               <td><a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/delete.png"/></a></td>
            </tr>
            <? endforeach;?>
         </tbody>
      </table>
      <? echo form_close() ?>
      <?php if (count($firmalar) > 0) { ?>
            <div id="pagination" style="padding:10px;">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->admin_firma_model->total_rows . "</b> " . lang("adet") . " " . lang("ilan kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->admin_firma_model->total_rows;
                    $config['per_page'] = $this->config->item("firma_rowperpage");
                    $config['query_string_segment'] = "s";


                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
      <div style=" margin:10px;" style="">
            <?php echo form_button(array("content"=>lang("Tümünü Seç"),"class"=>"blue","onclick"=>"checkAll()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Gözde Firma Yap"),"class"=>"blue","onclick"=>"gozde()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Gözde Firmalardan Çıkar"),"class"=>"blue","onclick"=>"normal()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Aktif Hale Getir"),"class"=>"blue","onclick"=>"selectedActive()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Pasif Hale Getir"),"class"=>"blue","onclick"=>"selectedPasive()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Sil"),"class"=>"blue","onclick"=>"selectedDelete()"))?>
        </div>
        <div class="fix"></div>
        <? } ?>

      
   </div>
</div>