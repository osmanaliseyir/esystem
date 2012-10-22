<div style="margin:auto; position: relative; height: 170px; width:992px;"> 
<div id="slogan"></div>
        <div id="split"></div>
        <a id="signup" href="<?=base_url()?>signup"></a>
        <div id="subslogan">Meslektaşlarınız sizi bekliyor. Meslektaşlarınızın arasına bugün katılın.</div>
        <div id="loginContainer">
            <form action="<?= base_url() ?>login" method="post" id="loginForm" name="loginForm">
            <? echo form_input(array("name"=>"l-email","id"=>"l-email","placeholder"=>"E-posta Adresiniz","style"=>"font-size:12px; width:200px; border:0; margin:13px 5px 10px 35px")) ?>
            <? echo form_input(array("type"=>"password","name"=>"l-password","id"=>"l-password","placeholder"=>"Şifreniz","style"=>" font-size:12px; width:200px; border:0; margin:15px 5px 20px 35px")) ?>
            <?php echo form_checkbox(array("id" => "rememberme", "name" => "rememberme", "checked" => "checked", "value" => "1")); ?> <label for="rememberme" style="font-size:11px;">Beni Hatırla</label><br>
            <a href="<?= base_url() ?>sifremi-unuttum" style="margin-top:5px; margin-left:5px; display:block; font-size:11px;">Şifremi Unuttum</a>
            </form>
        </div>
        <a id="login" href="javascript:void(0)" onclick="$('#loginForm').submit()"></a>
</div>