<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<script type="text/javascript">
    $(function(){
        $('#q').keypress(function(e){
            if(e.which == 13){
                $('#friendSearch').submit()
            }
        });
    });
    
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
                    $("#resultFriend_"+id).html('İstek Gönderildi!');
                }else {
                    $("#result").html(resultFormat('warning',respond.msg));   
                }
            }   
        });
    }

</script>
<div id="leftPanel">
  <? require APPPATH.'blocks/profilim.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li><a href="<?= base_url() ?>profilim/arkadaslarim">Arkadaşlarım</a></li>
        </ul>
    </div>

    <div style="float:left; width:408px; margin-top:10px;">
        <img src="images/users.png" style="vertical-align:bottom"> <span style="font-size:18px; font-weight:bold; letter-spacing: -1px; color:#333333;">Arkadaşlarım</span>    
    </div>
    <div style="float:left; width:244px; margin-top:10px;">
        <form action="<?= base_url() ?>profilim/arkadaslarim/ara" method="get" id="friendSearch">
            <input type="input" id="q" name="q" style="border:1px solid #666666; padding:3px; width:244px; font-size:11px;" placeholder="Arkadaş Arayın"/>    
        </form>
    </div>
    <div class="fix"></div>

    <div style="margin-top:8px;padding-top:10px; border-top:1px solid #EEEEEE;">
        <div id="result"></div>
        <? if (count($arkadaslar) > 0) {
            foreach ($arkadaslar as $arkadas): ?>
                <div style="width:310px; float:left; margin-right:20px; height:80px; padding-top:10px;" class="borderbottom">
                    <div style="float:left; width:75px;">
                        <?
                        if ($arkadas->image != "" && file_exists("public/images/user/" . $arkadas->id . "/thumb1/" . $arkadas->image)) {
                            echo "<img style='padding:2px; border:1px solid #CCCCCC;' src='" . base_url() . "public/images/user/" . $arkadas->id . "/thumb1/" . $arkadas->image . "'>";
                        } else {
                            echo "<img style='padding:2px; border:1px solid #CCCCCC;' src='" . base_url() . "public/images/user.jpg'>";
                        }
                        ?>
                    </div>
                    <div style="float:left; width:105px; font-size:11px; line-height: 17px;">
                        <b><a style="color:#2F547E;" href='<?= base_url() ?>kullanici/<?= $arkadas->id ?>'><?= $arkadas->adsoyad ?></a></b><br>
                        <?= $arkadas->meslek ?>
                    </div>
                    <div style="float:left; width:120px; font-size:11px; color:#666666;">
                        <ul class="friendlistmenu">
                            <li><a href="<?= base_url() ?>kullanici/<?= $arkadas->id ?>">Profili</a></li>

                            <?
                            $query = $this->db->query("SELECT id,active FROM site_arkadas WHERE user_id='" . $this->session->userdata("user_id") . "' AND friend_id='" . $arkadas->id . "'");
                            if ($query->num_rows() > 0) {
                                $row = $query->row();
                                if ($row->active == 1) {
                                    echo "<li>" . $arkadas->adsoyad . " ile arkadaşsınız</li>";
                                } else if ($row->active == 0) {
                                    echo "<li>Yanıt Bekleniyor.</li>";
                                }
                            } else {
                                ?> <li id="resultFriend_<?=$arkadas->id?>"><a href="javascript:void(0)" onclick="addFriend(<?= $arkadas->id ?>)">Arkadaş olarak Ekle</a></li><?
                             }
                            ?>



                            <li><a href="<?= base_url() ?>profilim/mesajlarim/add?to=<?= $arkadas->id ?>">Mesaj Gönder</a></li>
                        </ul>
                    </div>
                </div>
                <?
            endforeach;
        } else {
            echo "<div class='warning'>";
            echo (isset($_GET["q"])) ? "'" . $_GET["q"] . "'" : "";
            echo " kelimesine uyan sonuç bulunamadı. Arama seçenekleri değiştirip tekrar arama yapabilirsiniz.</div>";
        }
        ?>
    </div>
    <div class="fix"></div>


    <?php if (count($arkadaslar) > 0) { ?>
        <div class="pagination">
            <div style="width:200px; font-size:11px; color:#666666; float:left;">
                <?php echo lang("Toplam") . " <b style='color:red'>" . $this->arkadas_model->total_rows . "</b> " . lang("adet") . " " . lang("kişi bulundu!") ?>
            </div>
            <div style="float:left; text-align: right; width:500px;">
                <?php
                $this->load->library('pagination');
                $url = "";
                $i = 0;
                if (isset($_GET)) {
                    foreach ($_GET as $k => $v) {
                        $i++;
                        if ($k != "s")
                            $url.=$k . "=" . $v;
                        $url.=($i != count($_GET)) ? "&" : "";
                    }
                }

                $config['num_links'] = 5;
                $config['first_link'] = '|&lt;';
                $config['prev_link'] = '&lt;';
                $config['next_link'] = '&gt;';
                $config['last_link'] = '&gt;|';
                $config['page_query_string'] = true;
                $config['base_url'] = base_url() . $this->uri->uri_string() . "?" . $url;
                $config['total_rows'] = $this->arkadas_model->total_rows;
                $config['per_page'] = 20;
                $config['query_string_segment'] = "s";

                $this->pagination->initialize($config);
                echo $pagination = $this->pagination->create_links();
                ?>
            </div>

        </div>
    <? } ?>
</div>