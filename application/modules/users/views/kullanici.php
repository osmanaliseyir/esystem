<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<script type="text/javascript">
    function addFriend(id){
        $("#result").html(resultFormat('pending','İstek Gönderiliyor...'));
        $.ajax({
            url:"<?= base_url() ?>profilim/arkadaslarim/add",
            type:'post',
            data:'id='+id,
            dataType:"json",
            success:function(respond){
                if(respond.success=="true"){
                    $("#result").html(resultFormat('success','Arkadaşlık İsteği Gönderildi!'));
                }else {
                    $("#result").html(resultFormat('warning','Hata : Arkadaşlık İsteği Gönderilemedi!'));   
                }
            }   
        });
    }

</script>
<div id="leftPanel">
    <? require APPPATH."blocks/profilim.php"; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>kullanici/<?= $user->id ?>"><?= $user->adsoyad ?></a></li>
            <li>Kullanıcı Detayı</li>
        </ul>
    </div>
    <?
    $user_id = $this->session->userdata("user_id");
    if (isset($user_id) && $user_id > 0) {
        ?>


        <div style="padding-top:10px;">
            <div style="width:220px; margin-right: 10px; float:left">
                <div class="block">
                    <div class="head"><?= $user->adsoyad ?></div>
                    <div style="padding:10px;">
                        <?
                        if ($user->image != "" && file_exists("public/images/user/" . $user->id . "/thumb200/" . $user->image)) {
                            echo "<img src='" . base_url() . "public/images/user/" . $user->id . "/thumb200/" . $user->image . "'>";
                        } else {
                            echo "<img src='" . base_url() . "public/images/user_big.jpg'>";
                        }
                        ?>
                    </div>
                </div>
                <div align="left" style="margin-top:10px;">

                    <?
                    $user_id = $this->session->userdata("user_id");
                    
                    if ($user_id!=$user->id) {
                        ?>
                        <a href="<?= base_url() ?>profilim/mesajlarim/add?to=<?= $user->id ?>"><img style="margin-bottom:5px;" src="images/mesajgonder.jpg"/></a>

                        <?
                        $query = $this->db->query("SELECT id,active FROM site_arkadas WHERE user_id='" . $this->session->userdata("user_id") . "' AND friend_id='" . $user->id . "'");
                        if ($query->num_rows() > 0) {
                            $row = $query->row();
                            if ($row->active == 1) {
                                echo "<div style='color:#666666; border-top:1px solid #EEEEEE; padding-top:9px;'>" . $user->adsoyad . " ile arkadaşsınız</div>";
                            } else if ($row->active == 0) {
                                echo "<div style='color:#666666; border-top:1px solid #EEEEEE; padding-top:9px;'>Arkadaşlık isteğiniz ile ilgili cevap bekleniyor.</div>";
                            }
                        } else {
                            ?><a href="javascript:void(0)" onclick="addFriend('<?= $user->id ?>')"><img style="margin-bottom:5px;" src="images/arkadasekle.jpg"/></a><?
            }
                        ?>


                        <?
                    }
                    ?>
                    <div id="result"></div>
                    <div style="font-size:11px; border-top:1px solid #EEEEEE; padding-top:7px; color:#666666; margin-top:10px;"><b>Üyelik Tarihi:</b>&nbsp; <?= dateFormat($user->savedate, "long") ?></div>
                </div>

            </div>
            <div style="width:430px; float:left">
                
                <div class="itemTitle">Arkadaşları</div>
                
                
                        <div style=" width:430px; display: inline-block">
                            <?
                            $sql = "SELECT site_users.*,site_meslek.name as meslek FROM site_arkadas INNER JOIN site_users ON site_arkadas.friend_id=site_users.id INNER JOIN site_meslek ON site_users.meslek=site_meslek.id WHERE site_arkadas.user_id='".$user->id."'  LIMIT 0,20";
                            $query2 = $this->db->query($sql);
                            if($query2->num_rows()>0){
                            foreach ($query2->result() as $friend){
                                ?>
                            <div style="padding:5px; width:60px; height: 60px; float:left;">
                                        <a href="<?=base_url()?>kullanici/<?=$friend->id?>">
                                            <?
                                            if($user->image!="" && file_exists("public/images/user/".$friend->id."/thumb1/".$friend->image."")){
                                                echo "<img class='ttip' title='".$friend->adsoyad."' style='margin-right:8px; border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/user/".$friend->id."/thumb1/".$friend->image."'>";
                                            } else {
                                                echo "<img class='ttip' title='".$friend->adsoyad."' style='margin-right:8px;border:1px solid #CCCCCC; padding:2px;' src='".base_url()."public/images/user.jpg'>";
                                            }
                                            ?>
                                        </a>

                                  </div>
                                <?
                            } 
                            ?>
                            <div class="fix"></div>
                            <div style=' display:block; margin-top:6px; font-size:11px; color:#666666;'><?=$user->adsoyad?> <?=$query2->num_rows() ?> arkadaşa sahip.</div>
                            <?
                            } else {
                                echo "<div class='warning'>".$user->adsoyad." henüz arkadaşa sahip değil.</div>";
                            }
                            ?>
                        </div>
                    
                <div class="itemTitle" style="margin-top:10px;">Kişisel Bilgileri</div>
               
                        <table width="100%" cellpadding="8" cellspacing="0" class="formTable" style="font-size:11px;">
                            <tr>
                                <td width="30%"><label>E-Posta Adresi</label></td>
                                <td><?= $user->email ?></td>
                            </tr>
                            <?
                            if ($kisisel->kisiselvisible == 1) {
                                ?>
                                <tr>
                                    <td><label>Cinsiyet</label></td>
                                    <td><?= (isset($kisisel->cinsiyet)) ? $this->cinsiyetler[$kisisel->cinsiyet] : "-"  ?></td>
                                </tr>
                                <tr>
                                    <td><label>Doğum Tarihi</label></td>
                                    <td><?= (isset($kisisel->dogumtarihi)) ? dateFormat($kisisel->dogumtarihi) : "-" ?></td>
                                </tr>
                            <? } ?>
                        </table> 
                    
              
                   <div class="itemTitle" style="margin-top:10px;">İletişim Bilgileri</div>

                
                    
                        <? if ($iletisim->iletisimvisible == 1) { ?>
                            <table width="100%" cellpadding="8" cellspacing="0" class="formTable" style="font-size:11px;">
                                <tr>
                                    <td width="30%"><label>Bulunduğu Yer</label></td>
                                    <td> <img src="images/icons/map-pin.png"/> 
                                        <?
                                        if (isset($iletisim->il) && $iletisim->il != "" && $iletisim->il != 0) {
                                            $query = $this->db->query("SELECT ad FROM il WHERE id='" . $iletisim->il . "'");
                                            $row = $query->row();

                                            echo $row->ad;
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <td><label>Cep Telefonu</label></td>
                                    <td><?= (isset($iletisim->ceptel) && $iletisim->ceptel!="") ? $iletisim->ceptel : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td><label>Ev Telefonu</label></td>
                                    <td><?= (isset($iletisim->evtel) && $iletisim->evtel!="") ? $iletisim->evtel : "-"; ?></td>
                                </tr>
                                <tr>
                                    <td><label>İş Telefonu</label></td>
                                    <td><?= (isset($iletisim->istel) && $iletisim->istel!="") ? $iletisim->istel : "-"; ?><?= (isset($iletisim->isteldahili) && $iletisim->isteldahili!="") ? " &nbsp;&nbsp;Dahili: ".$iletisim->isteldahili : ""; ?></td>
                                </tr>

                            </table>  <?
                            } else {
                                echo "<div class='warning'>" . $user->adsoyad . " iletişim bilgilerini paylaşmak istemiyor!</div>";
                            }
                                    ?>
                    
                
                   <div class="itemTitle" style="margin-top:10px;">Mesleki Bilgileri</div>
                        <table width="100%" class="formTable" style="font-size:11px;">
                            <tr>
                                <td width="30%"><label>Mesleği</label></td>
                                <?
                                $query = $this->db->query("SELECT name FROM site_meslek WHERE id='" . $user->meslek . "'");
                                $row = $query->row();
                                ?>
                                <td><?= $row->name ?></td>
                            </tr>
                        </table> 
                    
                


            </div>


        </div>
        <?
    } else {
        echo "<div class='warning'>Üye Profillerinizi görmek için giriş yapmanız gerekmektedir.  Üye iseniz <a href='" . base_url() . "login'>Giriş Yapın!</a>, değilseniz <a href='" . base_url() . "home'>Şimdi üye olun!</a></div>";
    }
    ?>
</div>


