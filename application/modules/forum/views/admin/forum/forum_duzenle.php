<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>
<script type="text/javascript">
    function setOrd(id){
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>admin/forum/forumlar/setOrd/',
            data:'meslek='+id,
            dataType:'json',
            success:function(respond){
                if(respond){
                    var data=respond.data;
                    var html="<option value='ilk'>En Başa</option>";
                    $.each(data, function(key, value) { 
                        html+="<option value='"+value.id+"'>"+value.name+" den sonra</option>";
                    });
                    html+="<option value='son'>En Sona</option>";
               
                    $("#ord").html(html);
               
                }
            }
        });
    }
    
    function formSubmit(){
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>admin/forum/forumlar/editsave/<?=$data["data"]->id."?token=".setToken($data["data"]->id)?>',
            data:$("#itemForm").serialize(),
            dataType:'json',
            success:function(respond){
                if(respond.success=="true"){
                    $("#result").html(resultFormat("success","Forum Başarıyla Kaydedilmiştir."));   
                } else {
                    $("#result").html(resultFormat("success","Hata : Forum Kaydedilemedi."));     
                }
            }
        });
        }
</script>   

<div id="leftPanel">
    <div class="block">
        <div class="head"><h3><?= lang("Forum İşlemleri") ?></h3></div>
        <ul class="listMenu">
            <li><a href="<?php echo base_url() ?>admin/forum/forumlar/add"><?php echo lang("Yeni Forum Ekle") ?></a></li>
            <li><a href="<?php echo base_url() ?>admin/forum/forumlar"><?php echo lang("Forumlar") ?></a></li>
        </ul>
    </div>
</div>
<div id="centerPanel" style="width:786px;">
    <div class="block">
        <div class="head"><h3><?= lang("Forum Düzenle") ?></h3></div>
        <div style="padding:10px;">
            <?
            $ords["ilk"]="En Başa"; foreach($data["ords"] as $row){ $ords[$row->ord]=$row->name."'den sonra"; }
            ?>
            
            <?php echo form_open("", array("name" => "itemForm", "id" => "itemForm")) ?>
            <table width="100%" cellpadding="6" cellspacing="0" class="formTable">
                <tr>
                    <td colspan="2"><div id="result"></div></td>
                </tr>
                <tr>
                    <td><?php echo lang("Meslek", "meslek") ?></td>
                    <td><?php echo form_dropdown("meslek_id", $meslekler, $data["data"]->meslek_id, "id='meslek_id' style='width:200px;' onchange='setOrd(this.value)'") ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Forum Adı", "name") ?></td>
                    <td><?php echo form_input(array("id" => "name", "name" => "name","value"=>$data["data"]->name,"style" => "width:200px;")) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Forum Sırası", "ord") ?></td>
                    <td><?php echo form_dropdown("ord", $ords, $data["selectedOrd"], "id='ord' style='width:200px;'") ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo form_button(array("content"=>"Kaydet","class"=>"blue","onclick"=>"formSubmit()")); ?></td>
                </tr>
            </table>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<div style="display:none" title="<?php echo lang("Üst Menü Seç") ?>" id="parentDialog">
    <div id="tree"></div>
</div>