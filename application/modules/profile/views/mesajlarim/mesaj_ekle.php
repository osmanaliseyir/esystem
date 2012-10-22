<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper(array("form", "date"));
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<script type="text/javascript">
    
    $(function(){
        $("#description").cleditor({ width:640, height:200});
        $('#filter').keypress(function(e){
            if(e.which == 13){
                search();
            }
        });
    })
    
    function search(){
        $.ajax({
            url:"<?= base_url() ?>profilim/mesajlarim/searchUser",
            type:'post',
            data:'filter='+$("#filter").val(),
            dataType:"json",
            success:function(respond){
                if(respond.success=="true"){
                    var data=respond.data;
                    var html="";
                    if(data.length>0){
                        $.each(data,function(key,value){
                            html+="<a style='display:block; padding:4px;' href='javascript:void(0)' onclick='selectUser(\""+value.id+"\",\""+value.adsoyad+"\")'>"+value.adsoyad+"</a>";
                        });
                        $("#users").html(html);
                    }else {
                        $("#users").html(resultFormat('warning','<?= lang("Kullanıcı Bulunamadı") ?>'));   
                    }
                } else {
                   
                }
            }
        });
    }
    
    function selectUser(id,adsoyad){
        $("#to").val(id);
        $("#toName").html(adsoyad);
        $("#dialogContainer").dialog("close");
    }
    
    
    function formSubmit(){
        
        if($("#to").val()==""){
            $("#result").html(resultFormat("warning","<?= lang("Mesajınızı Göndereceğiniz kişiyi seçmelisiniz!") ?>"));   
            return false;
        }
        if($("#name").val()==""){
            $("#result").html(resultFormat("warning","<?= lang("Mesaj Başlığını girmelisiniz!") ?>"));   
            return false;
        }
        if($("#description").val()==""){
            $("#result").html(resultFormat("warning","<?= lang("Mesaj içeriğini girmelisiniz!") ?>"));   
            return false;
        }
        
        $.ajax({
            url:"<?= base_url() ?>profilim/mesajlarim/send",
            type:'post',
            data:$("#messageForm").serialize(),
            dataType:"json",
            success:function(respond){
                if(respond.success=="true"){
                    document.getElementById("messageForm").reset();
                    $("#result").html(resultFormat("success","<?= lang("Mesajınız Başarıyla Gönderilmiştir.") ?>"));   
                } else {
                    $("#result").html(resultFormat("alert","<?= lang("Hata : Mesajınız Gönderilemedi.") ?>"));   
                }
            }
        });
    }
    
    function sec(){
        $("#dialogContainer").dialog({
            width:300,
            height:300,
            modal:true
        });
    }
    
     
    
</script>
<div id="leftPanel">
    <? require APPPATH . 'blocks/profilim.php'; ?>    
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li><a href="<?= base_url() ?>profilim/mesajlarim">Mesajlarım</a></li>
            <li>Mesaj Yaz</li>
        </ul>
    </div>

    <div class="itemTitle" style="margin-top:10px;">Mesaj Yaz</div>
    <div class="smalldesc" style="padding-top:10px;">Mesaj göndereceğiniz kişiyi seç butonuna basarak seçebilirsiniz.</div>
    <?php echo form_open("", array("id" => "messageForm", "name" => "messageForm")); ?>
    <table width="100%" cellpadding="6" cellspacing="0" class="formTable">
        <tr>
            <td colspan="2"><div id="result"></div></td>
        </tr>
        <tr>
            <td width="20%"><?php echo lang("Kime", "label") ?></td>
            <td>
                <input type="hidden" name="to" id="to" value="<?= (isset($data->from)) ? $data->from : '' ?>" >

                    <span id="toName">  
                        <?
                        if (isset($data->from)) {
                            $query = $this->db->query("SELECT adsoyad FROM site_users WHERE id='" . $data->from . "'");
                            $row = $query->row();
                            echo $row->adsoyad;
                        }
                        ?>
                    </span>
                    <a href="javascript:void(0)" onclick="sec()"><?php echo lang("Seç") ?></a></td>
        </tr>
        <tr>
            <td><?php echo lang("Mesaj Başlığı", "label") ?></td>
            <td><?php echo form_input(array("name" => "name", "id" => "name", "style" => "width:540px;", "value" => (isset($data->name)) ? 'Re:' . $data->name : '')) ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo form_textarea(array("name" => "description", "id" => "description", "style" => "width:640px; height:200px;", "value" => (isset($data->description)) ? '<br/><br/>------<br/>' . lang("Yönlendirilmiş İleti:") . "<br/>" . $data->description : '')) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo form_button(array("content" => lang("Cevap Yaz"), "style" => "width:200px;", "class" => "blue", "onclick" => "formSubmit()")) ?></td>
        </tr>
    </table>
    <?php echo form_close() ?>

</div>
<div id="dialogContainer" title="<?= lang("Kişi Seç") ?>" style="display:none">
    <div style="padding:10px;">
        <div class="smalldesc" style="padding-bottom:6px;">Kişi ismi:</div>
        <input type="textfield" id="filter" style="width:200px;"/>
        <div id="users"><div class="warning">Aramak istediğiniz kişinin ismini yazıp enter tuşuna basın!</div></div>
        
    </div>
</div>
