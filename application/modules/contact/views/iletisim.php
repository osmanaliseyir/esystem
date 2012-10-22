<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

$this->load->helper("form");
?>
<script type="text/javascript">
function formSubmit(){
    $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>iletisim/save',
                data: $("#contactForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        $("#result").html(resultFormat("success","<?php echo lang("Bilgileriniz başarıyla gönderilmiştir.") ?>"));
                    } else if (respond.success=="false") {
                        $("#result").html(resultFormat("warning",respond.msg));
                    }
                }
            });
}

</script>

<div id="leftPanel">
   
</div>
<div id="rightPanel">
        
      

        <div style="padding:10px">
            <?php echo form_open("",array("id"=>"contactForm","name"=>"contactForm")); ?>
        <table width="100%" cellpadding="5" cellspacing="0" class="formTable">
            <tr>
                <td colspan="2"><span class='smalldesc'><?php echo lang("Her türlü istek,öneri ve şikayetleriniz için bize ulaşabilirsiniz!") ?>
                    <?=$this->config->item("site_link")?> <?php echo lang("Müşteri Hizmetleri tarafından en kısa sürede size dönüş yapılacaktır.") ?>
                    </span></td>
            </tr>
            <tr>
                <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
                <td width="40%"><?php echo lang("Adınız Soyadınız","adsoyad") ?></td>
                <td><?php echo form_input(array("name"=>"adsoyad","id"=>"adsoyad","style"=>"width:200px")) ?></td>
            </tr>
            <tr>
                <td width="40%"><?php echo lang("E-Posta Adresiniz","email") ?></td>
                <td><?php echo form_input(array("name"=>"email","id"=>"email","style"=>"width:200px")) ?></td>
            </tr>
            <tr>
                <td width="40%"><?php echo lang("Telefonunuz","tel") ?> <span class="smalldesc"><?=lang("Opsiyonel")?></span></td>
                <td><?php echo form_input(array("name"=>"tel","id"=>"tel","style"=>"width:200px")) ?></td>
            </tr>
            <tr>
                <td width="40%"><?php echo lang("Başlık","name") ?></td>
                <td><?php echo form_input(array("name"=>"name","id"=>"name","style"=>"width:400px")) ?></td>
            </tr>
            <tr>
                <td width="40%" valign="top"><?php echo lang("Açıklama","description") ?></td>
                <td><?php echo form_textarea(array("name"=>"description","id"=>"description","style"=>"width:400px; height:100px;")) ?></td>
            </tr>
            <tr>
                <td width="40%" valign="top"><?php echo lang("Güvenlik Kodu","securitycode") ?></td>
                <td>
                <? 
               
                $this->load->helper("captcha");
                $vals = array(
                    'word' => $securitycode,
                    'img_path' => './public/captcha/',
                    'img_url' => base_url().'/public/captcha/',
                    'font_path' => './public/fonts/Myndraine.otf',
                    'img_width' => '200',
                    'img_height' => 40,
                    'expiration' => 7200
                    );

                $cap = create_captcha($vals);
                echo $cap['image'];
                
                ?><br/>
                    <?php echo form_input(array("name"=>"securitycode","id"=>"securitycode","style"=>"margin-top:5px; width:192px;")) ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo form_button(array("content"=>lang("Bilgileri Gönder"),"class"=>"blue","onclick"=>"formSubmit()")) ?></td>
            </tr>
        </table>
            <? echo form_close() ?>
            </div>
    
</div>
