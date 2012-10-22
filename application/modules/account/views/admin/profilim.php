<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper("date");
?>
<div id="leftPanel">
<?php require APPPATH . 'modules/account/widgets/adminUserAccount.php'; ?>
</div>
<div id="centerPanel">
   <div class="block">
      <div class="head"><h3><?php echo lang("Bilgileriniz") ?></h3></div>
      <div style="padding:10px;">

         <table width="100%" cellpadding="5" cellspacing="0" class="formTable">
            <tr>
               <td colspan="3"><img style="float:left; margin-right: 5px;" src="images/user/user-red.png"/> <h2><?php echo $data->username ?></h2></td>
            </tr>
            <tr>
               <td width="30%"><b><label><?php echo lang("Adınız Soyadınız"); ?></label></b></td>
               <td width="5%">:</td>
               <td><?php echo $data->adsoyad ?></td>
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
         </table>
      </div>
   </div>
</div>
<div id="rightPanel"></div>
