<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

//Administrator
$query = $this->db->query("SELECT id FROM site_yetkilendirme WHERE user_id='" . $this->session->userdata("user_id") . "' and meslek_id='" . $this->meslekid . "' and `type`='1'");
if ($query->num_rows() > 0) {
    ?>
    <script type="text/javascript">
        $(function(){
            $('#accordion').accordion();
           // $('#adminContent').hide();
            
          //toggle the componenet with class msg_body
           $("#contentBt").click(function(){
                 $("#adminContent").slideToggle("slow");
           });
            
            
        })
    </script>
<style>
    #accordion ul { margin: 0; padding: 0; list-style: none; list-style-image: none;}
    #accordion ul li {}
    #accordion ul li a{ display:block; padding:5px; border-bottom:1px solid #EEEEEE;}
    
</style>
    <div class="block" style="border:1px solid #CC3333;">
        <div class="head"><img src="images/icons/key.png"/> Admin Menüsü  <span class="right" style="padding:5px;" id="contentBt"><img src="images/icons/application-resize.png"/></span></div>
        <div style="" id="adminContent">
            <ul id="accordion">
                <li>
                    <h3><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/kullanicilar">Kullanıcılar</a></h3>
                </li>
                <li><h3><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/forumlar">Forumlar</a></h3></li>
                <li><h3><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/haberler">Haberler</a></h3>
                    <div>
                        <ul>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/haberler/add">Haber Ekle</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/haberler">Haberler</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/haberler/kategoriler">Haber Kategorileri</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/haberler/kategoriler/add">Haber Kategorisi Ekle</a></li>
                        </ul>
                    </div>
                </li>
                <li><h3><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/makaleler">Makaleler</a></h3>
                    <div>
                        <ul>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/makaleler/add">Makale Ekle</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/makaleler">Makaleler</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/makaleler/kategoriler">Makale Kategorileri</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/makaleler/kategoriler/add">Makale Kategorisi Ekle</a></li>
                        </ul>
                    </div>
                </li>
                <li><h3><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/ilanlar">İlanlar</a></h3>
                    <div>
                        <ul>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/ilanlar">Tüm İlanlar</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/ilanlar?active=0">Onay Bekleyen İlanlar</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/ilanlar/kategoriler">İlan Kategorileri</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/ilanlar/kategoriler/add">İlan Kategorisi Ekle</a></li>
                        </ul>
                    </div>
                </li>
                <li><h3><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/download">Download</a></h3>
                    <div>
                        <ul>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/download">Tüm Download'lar</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/download/yukle">Dosya Yükle</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/download/kategoriler">Download Kategorileri</a></li>
                            <li><a href="<?= base_url() . url_title($this->meslekname) ?>/admin/download/kategoriler/add">Download Kategorisi Ekle</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?
}


//Moderator
$query = "SELECT sm.id, sm.parent_id, sm.`name`, sm.url_name
        FROM site_yetkilendirme AS sy
        LEFT JOIN site_modules AS sm ON (sy.modul = sm.id)
        WHERE sy.user_id='" . $this->session->userdata("user_id") . "'
        AND sy.meslek_id='" . $this->meslekid . "'
        AND sm.parent_id='0'
        AND sy.type=2";
$select = $this->db->query($query);
if ($select->num_rows() > 0) {
    ?>
    <div class="block" style="border:2px solid #BC7303;">
        <div class="head">Moderator Menüsü</div>
        <div style="padding:10px;">
            <?
            echo "<ul>";
            $result = $select->result();
            foreach ($result AS $key => $module) {

                $query2 = "SELECT * FROM site_modules WHERE parent_id='" . $module->id . "' ";
                $select2 = $this->db->query($query2);
                if ($select2->num_rows() > 0) {
                    echo "<li>" . $module->name . "</li>";
                    echo "<ul>";
                    foreach ($select2->result() AS $key2 => $module2) {
                        echo "<li><a href='" . base_url() . url_title($this->meslekname) . "/admin/" . $module2->url_name . "'>" . $module2->name . "</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<li><a href='" . base_url() . url_title($this->meslekname) . "/admin/" . $module->url_name . "'>" . $module->name . "</a></li>";
                }
            }
            echo "</ul>";
            ?>
        </div>
    </div>
    <?
}
?>