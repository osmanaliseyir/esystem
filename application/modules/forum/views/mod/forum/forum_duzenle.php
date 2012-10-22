<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>
<script type="text/javascript">
      
    function formSubmit(){
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/forumlar/editsave/<?=$data["data"]->id."?token=".setToken($data["data"]->id)?>',
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
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">
    <div class="block">
        <div class="head"><?= lang("Forum Düzenle") ?></div>
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
                    <td><?php echo $this->meslekname ?></td>
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