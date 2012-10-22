<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

$this->load->helper("form");
?>
<script type="text/javascript">
   
   $(function(){
      $(".ttip").tipsy();
   });
   
    function configFormSubmit(){
       
        if( $("#site_title").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Başlığını Giriniz!") ?>"));   
            return false;
        }
        if( $("#site_description").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Açıklaması Giriniz!") ?>"));   
            return false;
        }
        if( $("#site_link").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Linkini Giriniz!") ?>"));   
            return false;
        }
        if( $("#site_author").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Sahibini Giriniz!") ?>"));   
            return false;
        }
        if( $("#site_keywords").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Anahtar Kelimeleri Giriniz!") ?>"));   
            return false;
        }
        if( $("#site_footer").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Footer ını Giriniz!") ?>"));   
            return false;
        }
        if( $("#site_language").val()==""){
            $("#result").html(resultFormat("warning","<?php echo lang("Site Dilini Giriniz!") ?>"));   
            return false;
        }
        
        $("#result").html(resultFormat("pending","<?php echo lang("Kaydediliyor...") ?> "));
        $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/config/save',
                data: $("#configForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        $("#result").html(resultFormat("success","<?php echo lang("Ayarlar Başarıyla Kaydedildi.") ?> "));
                    }else if (respond.success=="false") {
                        $("#result").html(resultFormat("warning","<?php echo lang("Ayarlarda Değişiklik Yapılmadı!") ?>"));
                    }
                }
            });  
        
    }
</script>

<div id="leftPanel">
    <? require APPPATH . "modules/config/widgets/configWidget.php" ?>
</div>
<div id="centerPanel">
    <div class="block">
        <div class="head"><h3><?= lang("Site Ayarları") ?></h3></div>
        <? echo form_open("", array("name" => "configForm", "id" => "configForm")); ?>
        <div style="padding:10px;">
            <table width="100%" class="formTable" cellpadding="4" cellspacing="0">
                <tr>
                    <td colspan="3"><div id="result"></div></td>
                </tr>
                <tr>
                    <td width="40%"><?php echo lang("Site Başlığı","site_title",lang("Site Başlığında gözüken ifadedir. Her Sayfada bu başlık gözükecektir.")) ?></td>
                    <td><?php echo form_input(array("name" => "site_title", "id" => "site_title", "style" => "width:200px;", "value" => $data["site_title"])) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Site Açıklaması","site_description",lang("Meta Tag: 'Description' olarak gözükecektir..")) ?></td>
                    <td><?php echo form_input(array("name" => "site_description", "id" => "site_description", "style" => "width:200px;", "value" => $data["site_description"])) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Site Linki","site_link",lang("Sitenin çeşitli yerlerinde kullanılmak üzere kaydedilmiştir.")) ?></td>
                    <td><?php echo form_input(array("name" => "site_link", "id" => "site_link", "style" => "width:200px;", "value" => $data["site_link"])) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Site Sahibi","site_author",lang("Meta Tag : 'Author' Site Sahibi")) ?></td>
                    <td><?php echo form_input(array("name" => "site_author", "id" => "site_author", "style" => "width:200px;", "value" => $data["site_author"])) ?></td>
                </tr>
                <tr>
                    <td><?php echo lang("Site Dili (Varsayılan)","site_language",lang("Varsayılan Site Dilidir.. Yüklü olan dillerden birini seçebilirsiniz!")) ?></td>
                    <td><?php echo form_dropdown("site_language",$languages,$data["site_language"],"id='site_language' style='width:208px;'") ?></td>
                </tr>
                <tr>
                    <td valign="top"><?php echo lang("Site Anahtar Kelimeleri","site_keywords",lang("Meta Tag: 'Keywords' Site Anahtar Kelimeleri")) ?></td>
                    <td><?php echo form_textarea(array("name" => "site_keywords", "id" => "site_keywords", "style" => "width:200px; height:100px;", "value" => $data["site_keywords"])) ?>
                       <br/><span class="smalldesc"><?php echo lang("Maksimum 255 karakter, Girdiğiniz kelimeleri virgül (,) ile ayırınız.. ") ?></span></td>
                </tr>
                <tr>
                    <td valign="top"><?php echo lang("Site Footer","site_footer",lang("Sitenin en alt kısmında bulunan açıklama kısmıdır!")) ?></td>
                    <td><?php echo form_textarea(array("name" => "site_footer", "id" => "site_footer", "style" => "width:200px; height:100px;", "value" => $data["site_footer"])) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php echo form_button(array("name" => "kaydet", "content" => lang("Ayarları Kaydet"), "class" => "blue", "onclick" => "configFormSubmit()", "style" => "width:130px;")) ?>
                        <?php echo form_button(array("name" => "vazgec", "content" => lang("Vazgeç"), "class" => "grey", "style" => "width:75px;")) ?>            
                    </td>
                </tr>
            </table>
            <?php echo form_close() ?>
        </div>
    </div>


</div>
<div id="rightPanel"></div>
