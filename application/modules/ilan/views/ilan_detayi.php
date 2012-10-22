<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

$this->load->helper("date");
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>externals/jquery-cleditor/jquery.cleditor.min.js"></script>
<script type="text/javascript">
    
    $(function(){
        $("#message").cleditor({ width:550, height:200});
    });
    
    function basvuruTamamla(){
        $.ajax({
            url:"<?= base_url() ?>ilanlar/basvuru/",
            type:'post',
            data:'message='+$("#message").val()+"&ilan_id=<?= $data->id ?>",
            dataType:"json",
            success:function(respond){
                if(respond.success=="true"){
                    $("#result").html(resultFormat("success","<?= lang("Başvurunuz Başarıyla Alınmıştır") ?>"));   
                } else {
                    $("#result").html(resultFormat("alert","<?= lang("Hata : Başvurunuz Kaydolmadı.") ?>"));   
                }
            }
        });
    }
</script>

<div id="leftPanel" style="width:200px;">
    <div class="subMenu">
        <ul>
            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/ilanlar/ilanlarim"><img src="images/icons/tickets.png"/> İlanlarım</a></li>
            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/ilanlar/ekle"><img src="images/icons/ticket--plus.png"/> Yeni İlan Ekle</a></li>
        </ul>
    </div>
    <? require APPPATH . "blocks/ilan_kategorileri.php" ?>
</div>
<div id="rightPanel" style="width:760px;">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar">İlanlar</a></li>
            <li><a href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar?category=<?=$data->category?>"><?=$data->categoryname?></a></li>
            <li>İlan Detayı</li>
        </ul>
        <span class="right"><span style="font-weight: normal;">İlan no:</span> <b style="color:#CC3333">#<?=$data->id?></b></span>
    </div>

    <div id="result" style="margin-top:5px;"></div>
    <div style="margin-top:10px; border-top:1px solid #CCCCCC; padding-top:10px;">

        <div style="width:500px; margin-bottom:10px; margin-right:10px; float:left; ">
            <b style="color:#2F547E; font-size:18px; font-weight: bold;"><?php echo $data->name ?></b><br>
            <div style="line-height: 20px; margin-top:5px; font-size:12px;">
                <div style="color:#666666; padding:0 0 10px 0; font-size:11px;" class="borderbottom">
                    <img src='images/icons/category.png' height="12"/> <?php echo $data->categoryname ?>&nbsp;&nbsp;&nbsp;
                    <img src="images/icons/calendar-small-month.png"/><?= dateFormat($data->savedate, "long") ?>&nbsp;&nbsp;&nbsp; 
                    <img src="images/icons/flag--plus.png"  height="12"/>    Görüntülenme: <?= $data->readnum ?>
                </div>

                <div style="padding:10px 0; font-size:14px; line-height: 20px;" class="borderbottom"> 
                    <?php echo nl2br($data->description) ?>
                </div>    

            </div>




            <!-- Bu kategorideki diğer ilanlar - AÇTIK DİV -->
            <? if (count($digerIlanlar) > 0) { ?>
                <div class="itemTitle" style="margin-top:10px;">Bu Kategorideki Diğer İlanlar</div>

                <?php foreach ($digerIlanlar AS $ilan): ?>
                    <div class="borderbottom" style="padding:5px 0; font-size:11px; line-height: 18px;">
                        <a style="color:#376598; font-weight: bold;" href="<?= base_url() ?><?= url_title($this->meslekname) ?>/ilanlar/<?= url_title($ilan->name) ?>-<?= $ilan->id ?>i.html"><?= $ilan->name ?></a>
                        <br><?= dateFormat($ilan->savedate, 'long') ?>
                    </div>
                <? endforeach; ?>





            <? } ?> 
            <!-- Bu kategorideki diğer ilanlar - DİV KAPADIK -->


        </div>
        <div style="float: left; width: 250px;">
            <?
            $query = $this->db->query("SELECT site_users.id,site_users.image,site_users.adsoyad,site_meslek.name as meslek FROM site_users INNER JOIN site_meslek ON site_users.meslek=site_meslek.id WHERE site_users.id='" . $data->user_id . "'");
            //ilanı ekleyen böyle bir kullanıcı hala var mı?
            if ($query->num_rows() > 0) {
                $user = $query->row();

                $query2 = $this->db->query("SELECT * FROM site_user_iletisim WHERE user_id='" . $data->user_id . "'");
                $iletisim = $query2->row();
                ?>

                <div class="itemTitle">İlan Sahibi</div>
    <?
    if ($user->image != "" && file_exists("public/images/user/" . $user->id . "/thumb1/" . $user->image . "")) {
        echo "<img class='ttip' title='" . $user->adsoyad . "' style=' float:left; margin-right:8px; border:1px solid #CCCCCC; padding:2px;' src='" . base_url() . "public/images/user/" . $user->id . "/thumb1/" . $user->image . "'>";
    } else {
        echo "<img class='ttip' title='" . $user->adsoyad . "' style=' float:left; margin-right:8px;border:1px solid #CCCCCC; padding:2px;' src='" . base_url() . "public/images/user.jpg'>";
    }
    ?>
                <b style="margin-bottom:3px; display: block;"><?= $user->adsoyad ?></b>
                <span style="color:#666666;"><?= $user->meslek ?></span><br>
                <div style="font-size:11px; margin-top:4px;">
                    <img src="images/blocker.jpg"/> <a href="<?= base_url() ?>kullanici/<?= $user->id ?>">Profili</a> &nbsp;&nbsp;&nbsp; <img src="images/blocker.jpg"/> <a href="<?= base_url() ?>profilim/mesajlarim/add?to=<?= $user->id ?>">Mesaj Gönder</a>
                </div>

                <div class="fix"></div>
                 <? 
                 if(isset($data->iletisimvisible) && $data->iletisimvisible==1){
                 ?>
                <div class="itemTitle" style="margin-top:5px;">İletişim Bilgileri</div>
                <table width="100%" cellpadding="6" cellspacing="0" style="font-size:11px;">
                    <tr>
                        <td width="40%" style="border-bottom:1px solid #EEEEEE;"><b style="color:#666666;">Cep Telefonu:</b></td>
                        <td style="border-bottom:1px solid #EEEEEE;"><?= ($iletisim->ceptel != "") ? $iletisim->ceptel : "-" ?></td>
                    </tr>
                    <tr>
                        <td style="border-bottom:1px solid #EEEEEE;"><b style="color:#666666;">Ev Telefonu:</b></td>
                        <td style="border-bottom:1px solid #EEEEEE;"><?= ($iletisim->evtel != "") ? $iletisim->evtel : "-" ?></td>
                    </tr>
                    <tr>
                        <td style="border-bottom:1px solid #EEEEEE;"><b style="color:#666666;">İş Telefonu:</b></td>
                        <td style="border-bottom:1px solid #EEEEEE;"><?= ($iletisim->istel != "") ? $iletisim->istel : "-" ?> <?= ($iletisim->isteldahili != "") ? "/ " . $iletisim->isteldahili : "" ?></td>
                    </tr>
                </table>
               <? 
                 }
}
?>         
        </div>
        <div class="fix"></div>


    </div>
</div>
