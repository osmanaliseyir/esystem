<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<div id="leftPanel">
    <div style="padding:10px;">
        
    
    
<h1>Kullanıcı Girişi</h1>
<span class="smalldesc" style="display: block; margin-bottom:10px;">Sistemimizde kayıtlı olan e-posta adresinizi ve şifrenizi girerek giriş yapabilirsiniz</span>
            <div id="result" style="margin-bottom: 5px;"><? echo (isset($error)) ? "<div class='alert'>".$error."</div>" : ""?></div>
            <?php echo form_open(base_url()."login", array("id" => "loginForm", "name" => "signupForm")) ?>
            <table width="100%" cellpadding="4" cellspacing="1" class="formTable">
                <tr>
                    <td width="150"><label for="l-email">E-Posta Adresiniz</label></td>
                    <td><?php echo form_input(array("id" => "l-email", "name" => "l-email", "placeholder" => "E-Posta Adresiniz","value"=>(isset($_POST["l-email"])) ? $_POST["l-email"] : "", "class" => "inputHome")) ?></td>
                </tr>
                <tr>
                    <td><label for="l-email">Şifreniz</label></td>
                    <td><?php echo form_input(array("type" => "password", "id" => "l-password", "name" => "l-password", "placeholder" => "Şifreniz", "class" => "inputHome")) ?></td>
                </tr>
            </table>
            
            <div align="right" style="margin-top:10px;"><a href="javascript:void(0)" class="btn btnRed" onclick="$('#loginForm').submit()">Giriş Yap</a>
</div>
            <?php echo form_close() ?>
        

            </div>
</div>
<div id="rightPanel">
    <div style="padding:10px;">
        <h1>Facebook ile Bağlan</h1>
        <span class="smalldesc">Facebook hesabınız varsa Facebook üzerinden sitemize üye olabilirsiniz! 
            Facebook profiliniz sayesinde üye olmak için form doldurmanıza gerek yok.
            Üyelik Bilgileriniz profilinizden otomatik olarak alınır siz sadece sitemiz için şifre belirleyeceksiniz! O kadar.
        </span><br><br><br>
            <a class="btn btnDarkBlue" onclick="window.open('<?= base_url() ?>flogin','Facebook Login','location=9,status=0,scrollbars=0,  width=540,height=500')" style="margin-left:5px;" href="javascript:void(0)"><img src="images/facebook.png"  style="margin-right: 5px;"/> Facebook ile Bağlan</a>
            
            <br><br><br>
            <h1>Şifremi Unuttum?</h1>  
            <span class="smalldesc">
                Şifremi unuttum diye üzülmeyin..
                Şifrenizi mi unuttuysanız E-posta adresinize yeni bir şifre gönderip eski şifrenizi sıfırlıyoruz.. 
                Şifrenizi unuttuysanız <a href="<?=base_url()?>sifremi-unuttum">tıklayın</a>
            </span>
            
    </div>
    
</div>
