<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type="text/javascript">
        
    function signup(){
        if($("#adsoyad").val()==""){
            $("#result").html(resultFormat('warning','Adınızı ve Soyadınızı Girmelisiniz!'));
            return false;
        }
        if($("#email").val()==""){
            $("#result").html(resultFormat('warning','E-Posta Adresinizi Girmelisiniz!'));
            return false;
        }
        if(isEmail($("#email").val())==false){
            $("#result").html(resultFormat('warning','E-Posta Adresinizi aaa@bbb.ccc şeklinde Girmelisiniz!'));
            return false;
        }
        
        if($("#password").val()==""){
            $("#result").html(resultFormat('warning','Şifrenizi Girmelisiniz!'));
            return false;
        }
        if($("#password").val().length<4){
            $("#result").html(resultFormat('warning','Şifreniz en az 4 karakterli olmalıdır!'));
            return false;
        }
        if($("#meslek").val()==0){
            $("#result").html(resultFormat('warning','Mesleğinizi Seçiniz!'));
            return false;
        }
        $("#result").html(resultFormat('pending','Bilgileriniz Kaydediliyor...'));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>home/useradd',
            data: $("#signupForm").serialize(),
            dataType:'json',
            success:function(respond){  
                if(respond.success=="true"){
                    $("#result").html(resultFormat('success',respond.msg));
                    setTimeout("window.location='<?= base_url() ?>profilim'","2000");
                } else {
                    $("#result").html(resultFormat('alert',respond.msg));   
                }
            }
        });        
    }
</script>
<div id="leftPanel">

    <div style="padding:10px;">
        <h1>Şimdi Üye Olun.</h1>
        <span class="smalldesc" style="margin-bottom:10px; display: block;">Meslektaşlarınızın arasına katılma vakti geldi.</span>
                <div id="result"></div>
                 <?php echo form_open("", array("id" => "signupForm", "name" => "signupForm")) ?>
                <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
                    <tr>
                        <td><label for="adsoyad">Adınız Soyadınız</label></td>
                        <td><?php echo form_input(array("id" => "adsoyad", "name" => "adsoyad", "placeholder" => "Adınız Soyadınız", "class" => "inputHome")) ?></td>
                    </tr>
                    <tr>
                        <td><label for="email">E-posta Adresiniz</label></td>
                        <td><?php echo form_input(array("id" => "email", "name" => "email", "placeholder" => "E-Posta Adresiniz", "class" => "inputHome")) ?></td>
                    </tr>
                     <tr>
                        <td><label for="password">Şifreniz</label></td>
                        <td><?php echo form_input(array("type" => "password", "id" => "password", "name" => "password", "placeholder" => "Şifreniz", "class" => "inputHome")) ?></td>
                    </tr>
                    <tr>
                        <td><label for="meslek">Mesleğiniz</label></td>
                        <td><?php echo form_dropdown("meslek", $meslekler, "", "id='meslek' class='inputHome' style='width:214px;'") ?></td>
                    </tr>
                </table>
                
               
                
                
                
                
                <div align="right" style="margin-top:20px;">
                <a href="javascript:void(0)" class="btn btnRed" onclick="signup()">Hemen Üye Ol</a> 
                </div>
                <div style="padding:5px; margin-top:15px; color:#666666; font-size:11px;">
                    <a style='color:#333333' href="<?= base_url() ?>"><b>Kullanıcı Sözleşmesi?</b></a><br>
                    Üye Olduğunuzda Kullanıcı Sözleşmesini okuduğunuzu ve anladığınızı beyan etmiş olursunuz.
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