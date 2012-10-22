<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<div class="block">
    <div class="head">Aramıza Son Katılanlar</div>
    <div style="padding:5px; display: inline-block">
<?
$sql = "SELECT site_users.*,site_meslek.name as meslek FROM site_users INNER JOIN site_meslek ON site_users.meslek=site_meslek.id WHERE meslek='".$this->meslekid."' AND image!='' ORDER BY savedate DESC LIMIT 0,16";
$query = $this->db->query($sql);

foreach ($query->result() as $user){
    ?>
<div style="padding:4px; float:left;">
            <a href="<?=base_url()?>kullanici/<?=$user->id?>">
                <?
                if($user->image!="" && file_exists("public/images/user/".$user->id."/thumb/".$user->image."")){
                    echo "<img class='ttip' title='".$user->adsoyad."' style='border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/user/".$user->id."/thumb/".$user->image."'>";
                } else {
                    echo "<img class='ttip' title='".$friend->adsoyad."' style='border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/user.jpg'>";
                }
                ?>
            </a>
     
      </div>
    <?
}
?>
  
</div>
</div>