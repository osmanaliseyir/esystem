<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper(array("date","form"));
?>
<script type="text/javascript">
    function changeProfile(){
        if($("#adsoyad").val()==""){
            $("#result").html(resultFormat("warning","<?=lang("Adınızı Soyadınızı Giriniz!")?>"));
            return false;
        }
        $("#result").html(resultFormat("pending","Şifreniz Değiştiriliyor..."));   
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>admin/account/changeProfileCheck',
                data: $("#profileForm").serialize(),
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        $("#result").html(resultFormat("success","<?php echo lang("Bilgileriniz Başarıyla Değiştirildi..") ?>"));
                        setTimeout("window.location='<?php echo base_url()?>admin/account'",2000);
                    } else if (respond.success=="false") {
                        $("#result").html(resultFormat("alert",respond.msg));
                    }
                }
            });
        
    }
</script>

<div id="leftPanel">
<?php require APPPATH . 'modules/account/widgets/adminUserAccount.php'; ?>
</div>
<div id="centerPanel">
   <div class="block">
      <div class="head"><h3><?php echo lang("Hesap Bilgilerimi Değiştir") ?></h3></div>
      <div style="padding:10px;">
         <?php echo form_open("",array("id"=>"profileForm","name"=>"profileForm")) ?>
         <table width="100%" cellpadding="5" cellspacing="0" class="formTable">
            <tr>
               <td colspan="3"><img style="float:left; margin-right: 5px;" src="images/user/user-red.png"/> <h2><?php echo $data->username ?></h2>
                   <div id="result"></div>
               </td>
            </tr>
            <tr>
               <td width="30%"><b><label for='adsoyad'><?php echo lang("Adınız Soyadınız"); ?></label></b></td>
               <td width="5%">:</td>
               <td><?php echo form_input(array("name"=>"adsoyad","id"=>"adsoyad","value"=>$data->adsoyad,"style"=>"width:200px;")); ?></td>
            </tr>
            <tr>
               <td width="30%"><b><label><?php echo lang("Kullanıcı Grubu"); ?></label></b></td>
               <td width="5%">:</td>
               <td><?php echo $data->belonggroup ?> <span class="smalldesc">(Bu değişecek grupları yapınca..)</span></td>
            </tr>
            <tr>
               <td><b><label><?php echo lang("Üyelik Tarihi"); ?></label></b></td>
               <td>:</td>
               <td><?php echo dateFormat($data->uyeliktarihi,"long") ?></td>
            </tr>
            <tr>
               <td><b><label><?php echo lang("Sisteme Son Giriş Tarihi"); ?></label></b></td>
               <td>:</td>
               <td><?php echo dateFormat($data->songiristarihi, "long") ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <?php echo form_button(array("name"=>"kaydet","class"=>"blue","content"=>lang("Profil Bilgilerim Değiştir"),"onclick"=>"changeProfile()")); ?>
                    <?php echo form_button(array("name"=>"vazgec","class"=>"grey","content"=>lang("Vazgeç"),"onclick"=>"window.location='".base_url()."admin/account'")); ?>
                </td>
            </tr>
         </table>
          <?php echo form_close(); ?>
      </div>
   </div>
</div>
<div id="rightPanel"></div>
