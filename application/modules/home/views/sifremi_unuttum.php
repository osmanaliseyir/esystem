<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type="text/javascript">
    function forgotpassword(){
        if($("#f-email").val()==""){
            $("#result").html(resultFormat('warning','E-Posta Adresinizi Girmelisiniz!'));
            return false;
        }
        if(isEmail($("#f-email").val())==false){
            $("#result").html(resultFormat('warning','E-Posta Adresinizi aaa@bbb.ccc şeklinde Girmelisiniz!'));
            return false;
        }
        $("#result").html(resultFormat('pending','Bilgileriniz Kontrol Ediliyor...'));
        $.ajax({
            type:'POST',
            url:'<?=base_url()?>/home/userforgotpassword',
            data: $("#passwordForm").serialize(),
            dataType:'json',
            success:function(respond){  
                if(respond.success=="true"){
                     $("#result").html(resultFormat('success',respond.msg));
                } else {
                     $("#result").html(resultFormat('alert',respond.msg));   
                }
            }
        });       
    }
       

</script>
<div id="leftPanel">
    
    <div style="padding:10px;">
        <h1>Şifremi Unuttum</h1>
        
        
            <form id="passwordForm" name="passwordForm" accept-charset="utf-8" method="post" action="http://e-meslek.net/">
                <div style="margin-bottom:10px; color:#666666; font-size:11px;">
                    Şifrenizi mi unuttuysanız E-posta adresinize yeni bir şifre gönderip eski şifrenizi sıfırlıyoruz..
                    <br>
                    <br>
                    Artık eski şifreniz kullanılamayacaktır, Yeni bir şifre oluşturulup mail adresinize gönderilmektedir..
                </div>
                <div id="result"></div>
                <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
                    <tr>
                        <td><label for="f-email">E-Posta Adresiniz</label></td>
                        <td><input id="f-email" class="inputHome" type="text" placeholder="E-Posta Adresiniz" value="" name="f-email"></td>
                    </tr>
                </table>
                
                    <div align="right" style="margin-top:20px; margin-bottom:20px; margin-right:20px;">
                        <a class="btn btnRed" onclick="forgotpassword()" href="javascript:void(0)">Yeni Şifremi Gönder</a>
                    </div>
            </form>
    </div>
    
    
       
   

</div>
