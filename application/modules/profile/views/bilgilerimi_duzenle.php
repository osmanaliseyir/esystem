<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type="text/javascript" src="<?=base_url()?>externals/masked-input.js"></script>
<script type="text/javascript">
    $(function(){
       $("#ceptel").mask("9 (999) 999 99 99"); 
       $("#istel").mask("9 (999) 999 99 99"); 
       $("#evtel").mask("9 (999) 999 99 99"); 
    });
    
    function formSubmit(){
        if($("#adsoyad").val()==""){
         $("#result").html(resultFormat("warning","Ad Soyad bölümünü boş bırakamazsınız!"));   
         return false;
        }
        $("#result").html(resultFormat("pending","Bilgileriniz Kaydediliyor..."));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>profilim/kaydet',
            data: $("#informationForm").serialize(),
            dataType:'json',
            success:function(respond){  
                if(respond.success=="true"){
                    $("#result").html(resultFormat("success",""+respond.msg+""));                  
                }else if (respond.success=="false") {
                    $("#result").html(resultFormat("alert",respond.msg));
                }
            }
        }); 
        
    }
</script>
<div id="leftPanel">
  <? require APPPATH.'blocks/profilim.php'; ?>  
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
        <li><a href="<?=base_url()?>">Anasayfa</a></li>
        <li><a href="<?=base_url()?>profilim">Profilim</a></li>
        <li>Bilgilerimi Düzenle</li>
        </ul>
     </div>
    <?php echo form_open("",array("id"=>"informationForm","name"=>"informationForm")) ?>
    
    
    <div class="itemTitle" style="margin-top:10px;">Kişisel Bilgilerim</div>
    
        <span class="smalldesc">Kişisel Bilgileriniz üçüncü şahıslarla paylaşılmamaktadır. Üye olmayan şahıslar sizin bilgilerinizi göremezler. 
                    Üye olanlar ise sadece sizin gösterilmesini seçtiğiniz bilgilerinizi görebilirler.
                    Bilgilerinizin diğer üyeler tarafından görülmesini istemiyorsanız aşağıda bulunan kutucuklardan bu isteğinizi gerçekleştirebilirsiniz.
                </span>
            <div id="result" style="margin-top:10px;margin-bottom:10px;"></div>
           
        <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td width="20%"><?php echo lang("Adınız Soyadınız","adsoyad")?></td>
            <td><?php echo form_input(array("id"=>"adsoyad","name"=>"adsoyad","style"=>"width:200px;","value"=>(isset($data["user"]->adsoyad)) ? $data["user"]->adsoyad : "")) ?></td>
        </tr>
        <tr>
            <td><?php echo lang("Cinsiyet","cinsiyet")?></td>
            <td><?php echo form_dropdown("cinsiyet",$this->cinsiyetler,(isset($data["kisisel"]->cinsiyet)) ? $data["kisisel"]->cinsiyet : "","id='cinsiyet'") ?></td>
        </tr>
        <tr>
            <td><?php echo lang("Doğum Tarihi","dtgun")?></td>
            <td>
                <?php $dt=explode("-",(isset($data["kisisel"]->dogumtarihi)) ? $data["kisisel"]->dogumtarihi : ""); ?>
                <?php echo form_dropdown("dtgun",$this->dtgun,(isset($dt[2])) ? $dt[2] : "","id='dtgun' style='width:80px;'") ?>
                <?php echo form_dropdown("dtay",$this->dtay,(isset($dt[1])) ? $dt[1] : "","id='dtay' style='width:80px;'") ?>
                <?php echo form_dropdown("dtyil",$this->dtyil,(isset($dt[0])) ? $dt[0] : "","id='dtyil' style='width:80px;'") ?>
            </td>
        </tr>
         <tr>
            <td></td>
            <td style="font-size:11px; color:#666666"><?php echo form_checkbox(array("id"=>"kisiselvisible","name"=>"kisiselvisible","value"=>"1","checked"=>(isset($data["kisisel"]->kisiselvisible)) ? $data["kisisel"]->kisiselvisible : "")) ?> Kişisel Bilgilerim üyeler tarafından gözüksün (Ad Soyad Haricindekiler için)</td>
        </tr>
        </table>
            
        <div class="itemTitle" style="margin-top:10px;">İletişim Bilgilerim</div>
        <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
        <tr>
            <td width="20%"><?php echo lang("E-Posta Adresiniz","email")?></td>
            <td><?php echo form_input(array("id"=>"email","name"=>"email","value"=>(isset($data["user"]->email)) ? $data["user"]->email : "","style"=>"width:200px;")) ?></td>
        </tr>
        <tr>
            <td width="20%"><?php echo lang("Cep Telefonunuz","evtel")?></td>
            <td><?php echo form_input(array("id"=>"ceptel","name"=>"ceptel","value"=>(isset($data["iletisim"]->ceptel)) ? $data["iletisim"]->ceptel: "","style"=>"width:200px;")) ?></td>
        </tr>
        <tr>
            <td width="20%"><?php echo lang("Ev Telefonunuz","evtel")?></td>
            <td><?php echo form_input(array("id"=>"evtel","name"=>"evtel","value"=>(isset($data["iletisim"]->evtel)) ? $data["iletisim"]->evtel: "","style"=>"width:200px;")) ?></td>
        </tr>
        <tr>
            <td width="20%"><?php echo lang("İş Telefonunuz","ceptel")?></td>
            <td><?php echo form_input(array("id"=>"istel","name"=>"istel","value"=>(isset($data["iletisim"]->istel)) ? $data["iletisim"]->istel: "","style"=>"width:200px;")) ?> <?=lang("Dahili","isteldahili")?> <?php echo form_input(array("id"=>"isteldahili","name"=>"isteldahili","value"=>(isset($data["iletisim"]->isteldahili)) ? $data["iletisim"]->isteldahili: "","style"=>"width:40px;"))?></td>
        </tr>
        <tr>
            <td width="20%"><?php echo lang("Yaşadığınız Yer","il")?></td>
            <td><?php echo form_dropdown("il",$this->iller,(isset($data["iletisim"]->il)) ? $data["iletisim"]->il : "","") ?></td>
        </tr>
        <tr>
            <td></td>
            <td style="font-size:11px; color:#666666"><?php echo form_checkbox(array("id"=>"iletisimvisible","name"=>"iletisimvisible","value"=>"1","checked"=>(isset($data["iletisim"]->iletisimvisible)) ? $data["iletisim"]->iletisimvisible : "")) ?> İletişim Bilgilerim üyeler tarafından gözüksün</td>
        </tr>
        </table>
         <div class="itemTitle" style="margin-top:10px;">Mesleki Bilgilerim</div>
        <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
        <tr>
            <td width="20%"><?php echo lang("Mesleğiniz","meslek","Mesleğinizi Değiştirirseniz anasayfanızda değiştirmiş olduğunuz yeni mesleğinize dair bilgiler gözükecektir.")?></td>
            <td><?php echo form_dropdown("meslek",$meslekler,(isset($data["user"]->meslek)) ? $data["user"]->meslek : "","") ?></td>
        </tr>
        <tr>
            <td></td>
            <td><a href="javascript:void(0)" class="btn btnRed btnSmall" onclick="formSubmit()">Bilgilerimi Kaydet</a></td>
        </tr>
    </table>
    <? echo form_close();?>
</div>
    
    
