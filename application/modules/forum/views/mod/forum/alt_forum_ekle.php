<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper(array("form", "date"));
?>
<script type="text/javascript">
     $(function(){
       setOrd('<?=$id?>');
     });
    function setOrd(id){
        $.ajax({
            type:'POST',
            url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/forumlar/setSubOrd/',
            data:'forum='+id,
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
            url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/forumlar/saveSubForum/',
            data:$("#itemForm").serialize(),
            dataType:'json',
            success:function(respond){
                if(respond.success=="true"){
                    setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/forumlar'",2000);
                    document.getElementById("itemForm").reset();
                    $("#result").html(resultFormat("success","Alt Forum Başarıyla Kaydedilmiştir."));   
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
        <div class="head"><?= lang("Alt Forum Ekle") ?></div>
        <div style="padding:10px;">
            <?php echo form_open("", array("name" => "itemForm", "id" => "itemForm")) ?>
            <table width="100%" cellpadding="6" cellspacing="0" class="formTable">
                <tr>
                    <td colspan="2"><div id="result"></div></td>
                </tr>
                <tr>
                    <td><?php echo lang("Üst Forum", "forum_id") ?></td>
                    <td><?php echo form_dropdown("forum_id", $forumlar, $id, "id='forum_id' style='width:200px;' onchange='setOrd(this.value)'") ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Alt Forum Adı", "name") ?></td>
                    <td><?php echo form_input(array("id" => "name", "name" => "name", "style" => "width:200px;")) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Alt Forum Açıklaması", "description") ?></td>
                    <td><?php echo form_input(array("id" => "description", "name" => "description", "style" => "width:200px;")) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Alt Forum Sırası", "ord") ?></td>
                    <td><?php echo form_dropdown("ord", array("" => "Meslek Seçmelisiniz"), "", "id='ord' style='width:200px;'") ?></td>
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