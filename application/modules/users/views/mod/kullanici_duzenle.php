<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<script type="text/javascript">

function formSubmit(){
        if($("#adsoyad").val()==""){
         $("#result").html(resultFormat("warning","Ad Soyad bölümünü boş bırakamazsınız!"));   
         return false;
        }
        $("#result").html(resultFormat("pending","Bilgiler Kaydediliyor..."));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?><?=url_title($this->meslekname)?>/admin/kullanicilar/editsave/<?=$kullanici->id?>?token=<?=setToken($kullanici->id."users")?>',
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
    <? require APPPATH . "blocks/admin_yetki.php"; ?>
</div>
<div id="rightPanel">
    <div class="block">
        <div class="head">Kullanıcı Düzenle</div>

        <div style="float: left; width:200px; padding:10px;">
            <?
            if ($kullanici->image != "" && file_exists("public/images/user/" . $kullanici->id . "/thumb1/" . $kullanici->image . "")) {
                echo "<img class='ttip' title='" . $kullanici->adsoyad . "' style=' float:left; margin-right:8px; border:1px solid #CCCCCC; padding:2px;' src='" . base_url() . "public/images/user/" . $kullanici->id . "/thumb200/" . $kullanici->image . "'>";
            } else {
                echo "<img class='ttip' style=' float:left; margin-right:8px;border:1px solid #CCCCCC; padding:2px;' src='" . base_url() . "public/images/user_big.jpg'>";
            }
            ?>
        </div>
        <div style="float:left;width:440px;">

            <div id="result"></div>
            <form id="informationForm" name="informationForm" action="" method="post">
            <div style="padding:10px;">
                <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
                    <tr>
                        <td width="40%"><label for="adsoyad">Adı Soyadı</label></td>
                        <td><?php echo form_input(array("id" => "adsoyad", "name" => "adsoyad", "value" => "" . $kullanici->adsoyad . "")) ?></td>
                    </tr>
                    <tr>
                        <td><label for="email">E-posta Adresi</label></td>
                        <td><?php echo form_input(array("id" => "email", "name" => "email", "value" => "" . $kullanici->email . "")) ?></td>
                    </tr>
                    <tr>
                        <td><label for="password">Yeni Şifre</label></td>
                        <td><?php echo form_input(array("id" => "password", "name" => "password", "type" => "password")) ?></td>
                    </tr>
                    <tr>
                        <td><label for="password2">Yeni Şifre Tekrarı</label></td>
                        <td><?php echo form_input(array("id" => "password2", "name" => "password2", "type" => "password")) ?></td>
                    </tr>
                    <tr>
                        <td height="30"><label for="email">Kayıt Tarihi</label></td>
                        <td><?= dateFormat($kullanici->savedate) ?></td>
                    </tr>
                    <tr>
                        <td height="30"><label for="email">Profil Güncelleme Tarihi</label></td>
                        <td><?= dateFormat($kullanici->updatedate) ?></td>
                    </tr>
                    <tr>
                        <td><label for="active">Hesap Durumu</label></td>
                        <td><input type="radio" name="active" value="1" <?= ($kullanici->active == 1) ? "checked=checked" : "" ?>/>Aktif &nbsp;<input type="radio" name="active" <?= ($kullanici->active == 0) ? "checked=checked" : "" ?> value="0"/>Pasif  </td>
                    </tr>
                    <tr>


                    </tr>
                </table>

                <div class="itemTitle" style="margin-top: 10px;">Kişisel Bilgileri</div>
                <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
                    <tr>
                        <td width="35%"><label for="adsoyad">Cinsiyet</label></td>
                        <td><input type="radio" name="cinsiyet" value="1" <?= ($kisisel->cinsiyet == 1) ? "checked=checked" : "" ?>/>Erkek &nbsp;<input type="radio" name="cinsiyet" <?= ($kisisel->cinsiyet == 2) ? "checked=checked" : "" ?> value="0"/>Kadın  </td>
                    </tr>
                    <tr>
                        <td><?php echo lang("Doğum Tarihi", "dtgun") ?></td>
                        <td>
                            <?php $dt = explode("-", (isset($kisisel->dogumtarihi)) ? $kisisel->dogumtarihi : ""); ?>
                            <?php echo form_dropdown("dtgun", $this->dtgun, (isset($dt[2])) ? $dt[2] : "", "id='dtgun' style='width:80px;'") ?>
                            <?php echo form_dropdown("dtay", $this->dtay, (isset($dt[1])) ? $dt[1] : "", "id='dtay' style='width:80px;'") ?>
                            <?php echo form_dropdown("dtyil", $this->dtyil, (isset($dt[0])) ? $dt[0] : "", "id='dtyil' style='width:80px;'") ?>
                        </td>
                    </tr>
                </table>
                
                <div class="itemTitle" style="margin-top:10px;">İletişim Bilgileri</div>
        <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
        <tr>
            <td width="40%"><?php echo lang("Cep Telefonunuz","evtel")?></td>
            <td><?php echo form_input(array("id"=>"ceptel","name"=>"ceptel","value"=>(isset($iletisim->ceptel)) ? $iletisim->ceptel: "","style"=>"width:200px;")) ?></td>
        </tr>
        <tr>
            <td><?php echo lang("Ev Telefonunuz","evtel")?></td>
            <td><?php echo form_input(array("id"=>"evtel","name"=>"evtel","value"=>(isset($iletisim->evtel)) ? $iletisim->evtel: "","style"=>"width:200px;")) ?></td>
        </tr>
        <tr>
            <td><?php echo lang("İş Telefonunuz","ceptel")?></td>
            <td><?php echo form_input(array("id"=>"istel","name"=>"istel","value"=>(isset($iletisim->istel)) ? $iletisim->istel: "","style"=>"width:150px;")) ?> <?php echo form_input(array("id"=>"isteldahili","name"=>"isteldahili","value"=>(isset($iletisim->isteldahili)) ? $iletisim->isteldahili: "","style"=>"width:40px;"))?></td>
        </tr>
        <tr>
            <td><?php echo lang("Yaşadığınız Yer","il")?></td>
            <td><?php echo form_dropdown("il",$this->iller,(isset($iletisim->il)) ? $iletisim->il : "","") ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="button" value="Bilgilerimi Kaydet" onclick="formSubmit()"/>
            </td>
        </tr>
        </table>
                

            </div>
                </form>
        </div>
    </div>
</div>

<?
?>