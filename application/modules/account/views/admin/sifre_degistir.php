<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$this->load->helper("form");
?>

<script type="text/javascript">
    function changePass(){
        if($("#password").val()==""){
            $("#result").html(resultFormat("warning","<?=lang("Şu Anki Şifrenizi Giriniz!")?>"));
            return false;
        }
        if($("#passwordnew").val()==""){
            $("#result").html(resultFormat("warning","<?=lang("Yeni Şifrenizi Giriniz!")?>"));
            return false;
        }
        if($("#passwordnew2").val()==""){
            $("#result").html(resultFormat("warning","<?=lang("Yeni Şifrenizi tekrar giriniz!")?>"));
            return false;
        }
        if($("#passwordnew").val()!=$("#passwordnew2").val()){
            $("#result").html(resultFormat("warning","<?=lang("Yeni girmiş olduğunuz şifreler birbiri ile uyuşmuyor!")?>"));
            return false;
        }
        
        $("#result").html(resultFormat("pending","Şifreniz Değiştiriliyor..."));   
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/account/cpCheck',
                data: $("#cpForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        document.getElementById("cpForm").reset();
                        $("#result").html(resultFormat("success","<?php echo lang("Başarıyla Şifreniz Değiştirildi.. Profil Sayfasına Yönlendiriliyorsunuz") ?>"));
                        setTimeout("window.location='<?php echo base_url()?>admin/account'",2000);
                    } else if (respond.success=="false") {
                        $("#result").html(resultFormat("alert",respond.msg));
                    }
                }
            });
        
    }
    
    function formReset(){
       $("#result").html("");
        document.getElementById("cpForm").reset();
    }

</script>

<div id="leftPanel">
<?php require APPPATH . 'modules/account/widgets/adminUserAccount.php'; ?>
</div>
<div id="centerPanel">
   <div class="block">
      <div class="head"><h3><?php echo lang("Şifre Değiştir") ?></h3></div>
      <div style="padding:10px;">
          <?php echo form_open("",array("id"=>"cpForm","name"=>"cpForm")) ?>
         <table width="100%" cellpadding="4" cellspacing="0" class="formTable">
            <tr>
               <td colspan="3"><img style="float:left; margin-right: 5px;" src="images/user/user-password.png"/> <h2><?php echo lang("Şifre Değiştir") ?></h2></td>
            </tr>
            <tr>
               <td colspan="3">
                  <span class="smalldesc">
                     <?
                     echo lang("Güvenliğiniz için şifrenizi sık sık değiştirmeniz önerilir.") . " ";
                     echo lang("Kişisel güvenliğinizi artırmak için şifrenizin harf, rakam ve özel karakter kombinasyonundan oluşmasına ve uzun olmasına dikkat ediniz!")
                     ?>
                  </span>
                  <div style="padding:4px;" id="result"></div>
               </td>
            </tr>
            <tr>
               <td width="30%"><b><?php echo lang("Eski Şifreniz","password"); ?></b></td>
               <td width="5%">:</td>
               <td><? echo form_password(array("name" => "password","id"=>"password", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
               <td width="30%"><b><?php echo lang("Yeni Şifreniz","passwordnew"); ?></b></td>
               <td width="5%">:</td>
               <td><? echo form_password(array("name" => "passwordnew", "id" => "passwordnew", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
               <td><b><?php echo lang("Yeni Şifreniz (Tekrar)","passwordnew2"); ?></b></td>
               <td>:</td>
               <td><? echo form_password(array("name" => "passwordnew2", "id" => "passwordnew2", "style" => "width:200px;")) ?></td>
            </tr>
            <tr>
               <td></td>
               <td></td>
               <td>
                  <?
                  echo form_button(array("name"=>"button3","content" => lang("Şifremi Değiştir"), "class" => "blue"), "", "onclick='changePass()'")." ";
                  echo form_button(array("name"=>"button4","content" => lang("Vazgeç"), "class" => "grey"), "", "onclick='formReset()'");
                  ?>
               </td>
            </tr>
         </table>
          <?php echo form_close(); ?>
      </div>
   </div>
</div>
<div id="rightPanel"></div>