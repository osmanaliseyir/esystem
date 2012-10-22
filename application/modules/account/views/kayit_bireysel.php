<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper("form");
?>
<script type="text/javascript" src="<?php echo base_url() ?>externals/masked-input.js"></script>
<script type="text/javascript">
    $(function(){
        $("#dogumtarihi").mask("99/99/9999");
    });
   
    function formSubmit(){
        
        alert($("#okudum").val());
        
        if($("#adsoyad").val()==""){
            $("#result").html(resultFormat('warning','<?php echo lang("Adınızı ve Soyadınızı Giriniz!") ?>'));
            return false;
        }
        if($("#email").val()==""){
            $("#result").html(resultFormat('warning','<?php echo lang("Email Adresinizi Giriniz!") ?>'));
            return false;
        }
        if(isEmail($("#email").val())==false){
            $("#result").html(resultFormat('warning','<?php echo lang("Email Adresinizi \"aaa@bbb.ccc\" olacak şekilde Giriniz!") ?>'))
            return false;
        }
        if($("#password").val()==""){
            $("#result").html(resultFormat('warning','<?php echo lang("Şifrenizi Giriniz!") ?>'));
            return false;
        }
        if($("#password2").val()==""){
            $("#result").html(resultFormat('warning','<?php echo lang("Şifrenizi Tekrar Giriniz!") ?>'));
            return false;
        }
        if($("#password").val()!=$("#password2").val()){
            $("#result").html(resultFormat('warning','<?php echo lang("Girmiş olduğunuz şifreler birbiri ile uyuşmuyor!") ?>'));
            return false;
        }
        if($("#dogumtarihi").val()==""){
            $("#result").html(resultFormat('warning','<?php echo lang("Doğum Tarihinizi Giriniz!") ?>'));
            return false;
        }
        
        if($("#okudum").val()==""){
            $("#result").html(resultFormat('warning','<?php echo lang("Kullanıcı Sözleşmesini onaylamanız gerekmektedir!") ?>'));
            return false;
        }
      
        $("#result").html(resultFormat('pending','<?php echo lang("Bilgileriniz Kontrol Ediliyor!") ?>'));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>account/bireyselSave',
            data: $("#bireyselForm").serialize(),
            dataType:'json',
            success:function(respond){  
                if(respond.success=="true"){
                    $("#result").html(resultFormat("success","<?php echo lang("Kullanıcı Kaydınız Başarıyla Yapılmıştır.") ?><br/>"+respond.msg+"<br/><a href='<?php echo base_url() ?>account/login'><?php echo lang('Giriş Yapmak için Tıklayın') ?></a>"));
                    if(respond.active=="1"){
                        setTimeout("window.location='<?= base_url() ?>login'","3000");
                    } else {
                        setTimeout("window.location='<?= base_url() ?>account/activation?email="+respond.email+"'","3000");
                    }
                }else if (respond.success=="false") {
                    $("#result").html(resultFormat("alert",respond.msg));
                }
            }
        }); 
    }
</script>
<div id="leftPanel">
    <?php
    //İlan Kategorileri
    require APPPATH . 'blocks/ilan_kategorileri.php';

    //Firma Kategorileri
    require APPPATH . 'blocks/firma_kategorileri.php';
    ?>
</div>
<div id="centerPanel">
    <?php echo openBlock(lang("Bireysel Üyelik"), "grey600") ?>
    <div style="padding:10px">
        <?php echo form_open("", array("name" => "bireyselForm", "id" => "bireyselForm")) ?>
        <table class="formTable" width="100%" cellpadding="4" cellspacing="0">
            <tr>
                <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
                <td width="40%"><?php echo lang("Adınız Soyadınız", "adsoyad") ?></td>
                <td><?php echo form_input(array("name" => "adsoyad", "id" => "adsoyad", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
                <td><?php echo lang("E-posta Adresiniz", "email") ?></td>
                <td><?php echo form_input(array("name" => "email", "id" => "email", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Şifreniz", "password") ?></td>
                <td><?php echo form_input(array("type" => "password", "name" => "password", "id" => "password", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Şifreniz (Tekrar)", "password2") ?></td>
                <td><?php echo form_input(array("type" => "password", "name" => "password2", "id" => "password2", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Doğum Tarihiniz", "dogumtarihi") ?></td>
                <td><?php echo form_input(array("name" => "dogumtarihi", "id" => "dogumtarihi", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Cinsiyet", "cinsiyet") ?> <span class="smalldesc"><?php echo lang("Opsiyonel") ?></span></td>
                <td><?php echo form_radio(array("name" => "cinsiyet", "value" => "1")) . " " . lang("Erkek") ?> 
                    <?php echo form_radio(array("name" => "cinsiyet", "value" => "0")) . " " . lang("Kadın") ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang("Medeni Hal", "medenihal") ?> <span class="smalldesc"><?php echo lang("Opsiyonel") ?></span></td>
                <td><?php echo form_radio(array("name" => "medenihal", "value" => "1")) . " " . lang("Evli") ?> 
                    <?php echo form_radio(array("name" => "medenihal", "value" => "0")) . " " . lang("Bekar") ?>
                </td>
            </tr>
            <tr>
                <td><?php echo lang("Kullanıcı Sözleşmesi", "medenihal") ?><br/><br/><span class="smalldesc">
                        <a href="<?= base_url() ?>kullanici-sozlesmesi"><?= lang("Kullanıcı Sözleşmesini Büyük sayfada okumak için tıklayınız") ?></a></span></td>
                <td style="padding-top:10px;">
                    <div style="padding:5px; margin-bottom:5px; border:1px solid #EEEEEE;">
                    <div style="  padding:10px; width:380px; height:200px; overflow:auto">


                        <?
                        $query = $this->db->query("SELECT * FROM sys_pages WHERE urlname='kullanici-sozlesmesi' AND lang='" . $this->session->userdata("user_lang") . "'");
                        $row = $query->row();
                        echo $row->description;
                        ?>
                    </div></div>
                        
                    <?php echo form_checkbox(array("name" => "okudum","id"=>"okudum","value"=>"accept")) . " " . lang("Kullanıcı Sözleşmesini Okudum.") ?>
                </td>
            </tr>
            <tr>
                <td width="40%" valign="top"><?php echo lang("Güvenlik Kodu", "securitycode") ?></td>
                <td>
                    <?
                    $securitycode = rand(100000, 999999);
                    $data["securitycode"] = $securitycode;
                    $this->session->set_userdata('securitycode', $securitycode);


                    $this->load->helper("captcha");
                    $vals = array(
                        'word' => $securitycode,
                        'img_path' => './public/captcha/',
                        'img_url' => base_url() . '/public/captcha/',
                        'font_path' => './public/fonts/Myndraine.otf',
                        'img_width' => '200',
                        'img_height' => 40,
                        'expiration' => 7200
                    );

                    $cap = create_captcha($vals);
                    echo $cap['image'];
                    ?><br/>
                    <?php echo form_input(array("name" => "securitycode", "id" => "securitycode", "style" => "margin-top:5px; width:192px;")) ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo form_button(array("content" => lang("Kayıt İşlemini Tamamla"), "class" => "blue", "onclick" => "formSubmit()"));
                    ?>
                    <?php echo form_button(array("content" => lang("Vazgeç"), "class" => "grey")); ?>
                </td>
            </tr>
        </table> 
        <?php echo form_close() ?>
    </div>
    <?php echo closeBlock("grey600") ?>
</div>
<div id="rightPanel">
    <?
    //Dil Seçimi
    require APPPATH . 'blocks/diller.php';
    ?>

    <?php echo openBlock(lang("Üye İseniz")) ?>
    <div style="padding:10px">
        <?php echo lang("Sitemize üye iseniz e-posta adresiniz ve şifreniz ile giriş yapabilirsiniz"); ?>
        <div style="margin-top:6px;" align="center">
            <?php echo form_button(array("content" => lang("Üye Girişi"), "class" => "blue", "style" => "width:120px;", "onclick" => "window.location='" . base_url() . "login'")); ?>
        </div>
    </div>
    <?php echo closeBlock(); ?>

    <?php echo openBlock(lang("Şifremi Unuttum")) ?>
    <div style="padding:10px">
        <?php echo lang("Şifrenizi mi unuttuysanız E-posta adresinize yeni bir şifre gönderip eski şifrenizi sıfırlıyoruz.."); ?><br/>
        <span class="smalldesc"><?php echo lang("Tek Yapmanız gereken şifremi unuttum bölümünden e-posta adresinize yeni bir şifre istemek") ?></span>
        <div style="margin-top:6px;" align="center">
            <?php echo form_button(array("content" => lang("Şifremi Unuttum"), "class" => "blue", "style" => "width:120px;", "onclick" => "window.location='" . base_url() . "account/forgotpassword'")); ?>
        </div>
    </div>
    <?php echo closeBlock(); ?>
    <?
    //Firmalar
    require APPPATH . 'blocks/son_firmalar.php';
    ?>
</div>