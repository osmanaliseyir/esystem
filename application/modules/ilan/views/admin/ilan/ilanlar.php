<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.js"></script>
<script type="text/javascript">
   

    function itemDelete(id,token){
        var table=$("#example").dataTable();
        var u=confirm('<?php echo lang("Seçmiş olduğunuz ilanı silmek istediğinize emin misiniz?") ?>');
        if(u){
            $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/ilan/ilanlar/delete/'+id+'?token='+token,
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz ilan silinmiştir.") ?> "));
                        var position=table.fnGetPosition($("#row_"+id)[0]);
                        table.fnDeleteRow(position);
                    }else if (respond.success=="false") {
                        $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz ilan silinemedi!") ?>"));
                    }
                }
            }); 
        }
    }
    
    function selectedActive(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/ilan/ilanlar/active/',
                data:$("#ilanForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet ilan aktifleştirilmiştir.") ?> "));
                         setTimeout("window.location='<?=base_url()?>admin/ilan/ilanlar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
    
    function selectedPasive(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/ilan/ilanlar/pasive/',
                data:$("#ilanForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet ilan pasifleştirilmiştir.") ?> "));
                         setTimeout("window.location='<?=base_url()?>admin/ilan/ilanlar'",2000);
                    }else if (respond.success=="false") {
                         $("#result").html(resultFormat("success",respond.msg));
                    }
                }
            }); 
    }
    
    function selectedDelete(){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/ilan/ilanlar/deleteSelected/',
                data:$("#ilanForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                         $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz")?> "+respond.affected+" <?=lang("adet ilan silinmiştir.") ?> "));
                        setTimeout("window.location='<?=base_url()?>admin/ilan/ilanlar'",2000);
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
        <div class="head"><h3><?php echo lang("İlanlar") ?></h3></div>



        <div id="search" style="padding:14px 10px 5px 10px">
            <?php echo form_open(base_url() . "admin/ilan/ilanlar/detayliarama", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
            <?php echo form_input(array("name" => "q", "id" => "q", "style" => "width:300px;")); ?>
            
            <?php echo form_dropdown("category", $categoryDropdown, (isset($_GET["category"]))? $_GET["category"] : "", "id='category' style='padding:2px; width:200px;'"); ?>
            <?php echo form_dropdown("type", array(""=>lang("Tümü"),"1"=>lang("İş Arayanlar"),"2"=>lang("İş Verenler")), (isset($_GET["type"]))? $_GET["type"] : "", "id='type' style='padding:2px;'"); ?>
            <?php echo form_dropdown("active", array(""=>lang("Tümü"),"1"=>lang("Aktif"),"0"=>lang("Pasif")), (isset($_GET["active"]))? $_GET["active"] : "", "id='active' style='padding:2px;'"); ?>
            <?php echo form_button(array("content" => lang("Arama"), "class" => "smallblue", "onclick" => "$('#searchForm').submit()")) ?>
            <?php echo form_close() ?>
        </div>

        <div style="padding:0px;">
            <? echo form_open("",array("id"=>"ilanForm","name"=>"ilanForm")) ?>
            <input type="hidden" name="checkVal" id="checkVal" value="0"/>
            <? if (count($ilanlar) > 0) { ?>
                <table width="100%" cellpadding="6" cellspacing="0" class="display" style="border:1px solid #EEEEEE;">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?php echo lang("Tür") ?></th>
                        <th><?php echo lang("İsim") ?></th>
                        <th><?php echo lang("Kategori") ?></th>
                        <th><?php echo lang("İl") . "/" . lang("İlçe") ?></th>
                        <th><?php echo lang("Kaydetme Tarihi") ?></th>
                        <th><?php echo lang("Durumu") ?></th>
                        <th width="2%"></th>
                        <th width="2%"></th> 
                    </tr>
                    </thead>
                    <?php foreach ($ilanlar as $row) : ?>
                        <tr id="row_<?php echo $row->id ?>">
                            <td><input type="checkbox" name="sec[]" value="<?=$row->id?>"/></td>
                            <td><?php echo ($row->user_type == 1) ? lang("İş Arayanlar") : lang("İş Verenler") ?></td>
                            <td><b><?php echo $row->name ?></b><?=($row->user_type=="2") ? "<br/><a href='".base_url()."firmalar/detay/".$row->firmaid."'>".$row->firmaad."</a>" : ""?><span style="color:#999999"><br/></span></td>
                            <td><?php echo $row->categoryname ?></td>
                            <td><?php echo $row->il . "," . $row->ilce ?></td>
                            <td><?php echo dateFormat($row->savedate, 'long') ?></td>
                            <td><?=($row->active=="1") ? lang("Aktif"): lang("Pasif")?></td>
                            <td><a href="<?php echo base_url() ?>admin/ilan/ilanlar/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id) ?>"><img src="images/edit.png"/></a></td>
                            <td><a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/delete.png"/></a></td>
                        </tr>
                    <? endforeach; ?>
                </table><? } else { ?> 
                <div class="warning"><?php echo lang("Aradığınız Kriterlere Uyan İlan Kaydı Bulunamadı!") ?></div>
            <? } ?>
                <? echo form_close() ?>
        </div>

        <?php if (count($ilanlar) > 0) { ?>        
            <div id="pagination" style="padding:10px 10px 0 10px;">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->admin_ilan_model->total_rows . "</b> " . lang("adet") . " " . lang("ilan kaydı bulundu!") ?>
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
                    $config['total_rows'] = $this->admin_ilan_model->total_rows;
                    $config['per_page'] = $this->config->item("ilan_rowperpage");
                    $config['query_string_segment'] = "s";


                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <div class="fix"></div>
        <div style=" margin:10px;" style="">
            <?php echo form_button(array("content"=>lang("Tümünü Seç"),"class"=>"blue","onclick"=>"checkAll()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Aktif Hale Getir"),"class"=>"blue","onclick"=>"selectedActive()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Pasif Hale Getir"),"class"=>"blue","onclick"=>"selectedPasive()"))?>
            <?php echo form_button(array("content"=>lang("Seçilileri Sil"),"class"=>"blue","onclick"=>"selectedDelete()"))?>
        </div>
        <? } ?>




    </div>
</div>