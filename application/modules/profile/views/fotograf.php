<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

if (isset($_FILES) && count($_FILES) > 0) {

    require APPPATH . 'libraries/upload.php';

    $up = new upload_photo();
    $up->uploaddir = 'public/images/user/'.$this->session->userdata("user_id")."/";
    $up->uploaded_name = 'upload';
    $up->extensions = array("jpg", "png", "gif");
    $dosya_ismi = $up->single_upload_file();

    //Resize
    $up->image_resize_type = "width";
    $up->new_width = 150;
    $up->resize_image();

    $up->thumb_save_dir = $up->uploaddir . "thumb200/";
    $up->CroppedThumbnail(200, 200);
    
    $up->thumb_save_dir = $up->uploaddir . "thumb/";
    $up->CroppedThumbnail(44, 44);
    
    $up->thumb_save_dir = $up->uploaddir . "thumb1/";
    $up->CroppedThumbnail(58, 58);

    if ($dosya_ismi != "") {
        $this->db->query("UPDATE site_users SET image='".$dosya_ismi."' WHERE id='".$this->session->userdata("user_id")."'");
        $success="Resminiz Başarıyla Yüklenmiştir.";
        $session["user_image"]=$dosya_ismi;
        $this->session->set_userdata($session);
    } else {
        
    }
}
?>
<div id="leftPanel">
  <? require APPPATH.'blocks/profilim.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li>Fotoğraf Değiştir</li>
        </ul>
    </div>
    
    <div class="itemTitle" style="margin-top:10px;">Fotoğraf Değişikliği</div>
    
  
        <div class="smalldesc" style="margin:6px 0 15px 0; line-height: 16px;">Yüklediğiniz resmin boyutları 2MB'ten fazla olmamalıdır. Yüksek boyutlu resimleri küçültüp daha sonra sistemimize yüklemeyi deneyebilirsiniz!<br/> Yüklenen resimlerin içeriğinden yükleyen kişi sorumludur.</div>
        
        <div id="result"><? echo (isset($success)) ? "<div class='success'>".$success."</div>": "" ?></div>
        
        <div style="width:80px; margin-top:5px; float:left;">
<?
$query = $this->db->query("SELECT image FROM site_users WHERE id='" . $this->session->userdata("user_id") . "'");
$row = $query->row();
if ($row->image != "" && file_exists("public/images/user/" . $this->session->userdata("user_id") . "/" . $row->image . "")) {
    echo "<img style='padding:2px; border:1px solid #CCCCCC;' src='" . base_url() . "public/images/user/".$this->session->userdata("user_id")."/thumb1/".$row->image."'/>";
} else {
    echo "<img style='padding:2px; border:1px solid #CCCCCC;' src='" . base_url() . "public/images/user.jpg'/>";
}
?>
        </div>
        <div style="float: left; margin-top:5px; width:300px; line-height: 27px;">
            <form method="post" action="<?= base_url() . $this->uri->uri_string() ?>" name="imageForm" id="imageForm" enctype="multipart/form-data">
                <span style="font-size:11px;">Aşağıdaki kutuyu kullanarak resminizi yükleyebilirsiniz.</span><br/> 
                <input type="file" name="upload" id="upload"/><br> 
                <span style="font-size:11px;">Yüklediğiniz resim jpg, gif ya da png uzantılı olmalıdır.</span>
                <a href="javascript:void(0)" onclick="$('#imageForm').submit()"><img src="images/kaydet.jpg"/></a>
            </form>
        </div>
   
</div>