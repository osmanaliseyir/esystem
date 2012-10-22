<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
   $this->load->helper("form");
?>
<script type="text/javascript" src="<?php echo base_url() ?>externals/masked-input.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-treeview/jquery.treeview.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-treeview/jquery.treeview.js"></script>
<script type="text/javascript">
    
   function pickParent(){
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>firmalar/parents/',
         dataType:'json',
         success:function(respond){
            if(respond){
               var data=respond.data;
               var html="<ul id='treeMenu' class='filetree'>";
               html+=menuCreate(data);
               html+="</ul>";
               $("#tree").html(html);
               $("#tree").treeview({ collapsed:true});
            }
         }
      });  
      $("#parentDialog").dialog({
      width:400,
      height:300,
      modal:true
      });
      
   } 

   function menuCreate(data){
      var html="";
      $.each(data,function(key,value){
         html+="<li><span class='"+value.cls+"'><a href='javascript:void(0)' onclick='selectParent(\""+value.id+"\",\""+value.name+"\")'>"+value.name+"</a></span>";
         if(value.menu){
            html+="<ul>"; 
            html+=menuCreate(value.menu); 
            html+="</ul>"; 
         }
         html+="</li>";
      });
      return html;
   }

   function selectParent(id,name){
      $("#parentDialog").dialog('close');
      $("#categoryname").html(name);
      $("#category").val(id);
   }

   $(function(){
      $("#sabittel").mask("(999) 999 99 99");
      $("#ceptel").mask("(999) 999 99 99");
      $("#faks").mask("(999) 999 99 99");
   });
   
   function getIlces(id){
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>account/getIlcesJson',
         data: 'id='+id,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#ilce").html("");
               var html="";
               $.each(respond.data,function(key,value){
                 html+="<option value='"+value.id+"'>"+value.ad+"</option>";
               });
               $("#ilce").html(html);
            }else if (respond.success=="false") {
            }
         }
      }); 
   }
   
   function formSubmit(){
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
      if($("#name").val()==""){
       $("#result").html(resultFormat('warning','<?php echo lang("Firmanızın adını Giriniz!") ?>'));
       return false;
      }
      if($("#category").val()==""){
       $("#result").html(resultFormat('warning','<?php echo lang("Firmanıza ait bir kategori seçmeniz gerekmektedir!") ?>'));
       return false;
      }
     
      
      $("#result").html(resultFormat('pending','<?php echo lang("Bilgileriniz Kontrol Ediliyor!") ?>'));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url() ?>account/kurumsalSave',
         data: $("#bireyselForm").serialize(),
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
              document.getElementById("bireyselForm").reset();
               $("#result").html(resultFormat("success","<?php echo lang("Kurumsal Firma Kaydınız Başarıyla Yapılmıştır.") ?><br/>"+respond.msg+"<br/><a href='<?php echo base_url() ?>account/login'><?php echo lang('Giriş Yapmak için Tıklayın') ?></a>"));
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
    require APPPATH.'blocks/ilan_kategorileri.php'; 
   
    //Firma Kategorileri
    require APPPATH.'blocks/firma_kategorileri.php'; 
    ?>
</div>
<div id="centerPanel">
   <?php echo openBlock(lang("Kurumsal Üyelik"),"grey600") ?>
      <div style="padding:10px">
         <?php echo form_open("",array("name"=>"bireyselForm","id"=>"bireyselForm")) ?>
         <table class="formTable" width="100%" cellpadding="4" cellspacing="0">
             <tr>
                <td colspan="2"><div id="result"></div></td>
            </tr>
            <tr>
               <td width="60%"><?php echo lang("Adınız Soyadınız","adsoyad") ?></td>
               <td><?php echo form_input(array("name"=>"adsoyad","id"=>"adsoyad","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("E-posta Adresiniz","email") ?></td>
               <td><?php echo form_input(array("name"=>"email","id"=>"email","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Şifreniz","password") ?></td>
               <td><?php echo form_input(array("type"=>"password","name"=>"password","id"=>"password","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Şifreniz (Tekrar)","password2") ?></td>
               <td><?php echo form_input(array("type"=>"password","name"=>"password2","id"=>"password2","style"=>"width:200px;")) ?></td>
            </tr>
            <tr height="40">
               <td><?php echo lang("Firmanızın","label") ?></td>
               <td></td>
            </tr>
            <tr>
               <td><?php echo lang("Adı / Ünvanı","name") ?></td>
               <td><?php echo form_input(array("name"=>"name","id"=>"name","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Bulunduğu İl", "il") ?></td>
               <td><?php echo form_dropdown("il", $ils, "", "id='il' style='width:200px;' onchange='getIlces(this.value)'") ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Bulunduğu İlçe", "ilce") ?></td>
               <td><?php echo form_dropdown("ilce", $ilces, "", "id='ilce' style='width:200px;'") ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Kategori/Sektör", "category") ?></td>
               <td><span id="categoryname"></span> <a href="javascript:void(0)" onclick="pickParent()"><?php echo lang("Seç") ?></a>
                   <input type="hidden" id="category" name="category" value=""/></td>
            </tr>
            <tr>
               <td><?php echo lang("Sabit Telefonu","sabittel") ?> <span class="smalldesc"><?php echo lang("Opsiyonel") ?></span></td>
               <td><?php echo form_input(array("name"=>"sabittel","id"=>"sabittel","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Cep Telefonu","ceptel") ?> <span class="smalldesc"><?php echo lang("Opsiyonel") ?></span></td>
               <td><?php echo form_input(array("name"=>"ceptel","id"=>"ceptel","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Faksı","faks") ?> <span class="smalldesc"><?php echo lang("Opsiyonel") ?></span></td>
               <td><?php echo form_input(array("name"=>"faks","id"=>"faks","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("E-posta Adresi","firmaemail") ?></td>
               <td><?php echo form_input(array("name"=>"firmaemail","id"=>"firmaemail","style"=>"width:200px;")) ?></td>
            </tr>
            <tr>
               <td><?php echo lang("Firmanızın Adresi","adres") ?><br/><span class="smalldesc"><?php echo lang("Opsiyonel") ?></span></td>
               <td><?php echo form_textarea(array("name"=>"adres","id"=>"adres","style"=>"width:380px; height:50px;")) ?></td>
            </tr>
            <tr>
                <td><?php echo lang("Kullanıcı Sözleşmesi", "medenihal") ?><br/><br/><span class="smalldesc">
                        <a href="<?= base_url() ?>kullanici-sozlesmesi"><?= lang("Kullanıcı Sözleşmesini Büyük sayfada okumak için tıklayınız") ?></a></span></td>
                <td style="padding-top:10px;">
                    <div style="padding:5px; margin-bottom:5px; border:1px solid #EEEEEE;">
                    <div style="  padding:10px; width:360px; height:200px; overflow:auto">


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
                <td width="60%" valign="top"><?php echo lang("Güvenlik Kodu", "securitycode") ?></td>
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
                 <?php echo form_button(array("content"=>lang("Kayıt İşlemini Tamamla"),"class"=>"blue","onclick"=>"formSubmit()")); ?>
                 <?php echo form_button(array("content"=>lang("Vazgeç"),"class"=>"grey")); ?>
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
    require APPPATH.'blocks/diller.php'; 
    
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
    require APPPATH.'blocks/son_firmalar.php'; 
   
    ?>
</div>
<div style="display:none" title="<?php echo lang("Kategori Seç") ?>" id="parentDialog">
   <div id="tree"><div class="pending"><?=lang("Kategoriler Yükleniyor...")?></div></div>
</div>