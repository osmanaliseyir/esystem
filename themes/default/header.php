<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if($this->meslekname!=""){
    $meslekUrl=url_title($this->meslekname)."/";
} else if($this->session->userdata("user_meslekname")!="") {
    $meslekUrl=url_title($this->session->userdata("user_meslekname"))."/";
} else {
    $meslekUrl="";
}

    ?>


    <div id="header">
        <a id="logo" href="<?= base_url() ?>"></a>
        <div id="topnav">
            <ul>
                <li><a href="<?= base_url() ?>iletisim">İletişim</a></li>
                <li><a href="<?= base_url() ?>reklam">Reklam</a></li>
                <li><a href="<?= base_url() ?>yardim">Yardım</a></li>
                <li><a href="<?= base_url() ?>hakkimizda">Hakkımızda</a></li>
            </ul>
        </div>
        
        </div>
          <?  $user_id=$this->session->userdata("user_id"); ($user_id != "") ? require 'header-uye.php' : require 'header-normal.php'; ?>
        <div id="nav">
            <ul>
                <li <?=($this->uri->segment(1)=="" || ($this->uri->segment(1)!="" && $this->uri->segment(2)=="" && $meslekUrl!="" )) ? 'class="selected"' : "" ?> ><a  class="home" href="<?= base_url() ?><?=$meslekUrl?>"><span></span>Anasayfa</a></li>
                <li <?=($this->uri->segment(1)=="meslekler" || $this->uri->segment(2)=="meslekler") ? 'class="selected"' : "" ?>><a class="meslekler" href="<?= base_url() ?><?=$meslekUrl?>meslekler"><span></span>Meslekler</a></li>
                <li <?=($this->uri->segment(1)=="forumlar" || $this->uri->segment(2)=="forumlar" ) ? 'class="selected"' : "" ?>><a class="forums" href="<?= base_url() ?><?=$meslekUrl?>forumlar"><span></span>Forumlar</a></li>
              <? /*  <li <?=($this->uri->segment(1)=="isbirligi" || $this->uri->segment(2)=="isbirligi") ? 'class="selected"' : "" ?>><a class="isbirlik" href="<?= base_url() ?><?=$meslekUrl?>isbirligi"><span></span>İş Birliği</a></li> */ ?>
                <li <?=($this->uri->segment(1)=="haberler" || $this->uri->segment(2)=="haberler") ? 'class="selected"' : "" ?>><a class="haberler" href="<?= base_url() ?><?=$meslekUrl?>haberler"><span></span>Haberler</a></li>
              <? /*  <li <?=($this->uri->segment(1)=="etkinlikler" || $this->uri->segment(2)=="etkinlikler") ? 'class="selected"' : "" ?>><a class="etkinlikler" href="<?= base_url() ?><?=$meslekUrl?>etkinlikler"><span></span>Etkinlikler</a></li>  */ ?>
                <li <?=($this->uri->segment(1)=="ilanlar" || $this->uri->segment(2)=="ilanlar") ? 'class="selected"' : "" ?>><a class="ilanlar" href="<?= base_url() ?><?=$meslekUrl?>ilanlar"><span></span>İlanlar</a></li>
                <li <?=($this->uri->segment(1)=="firmalar" || $this->uri->segment(2)=="firmalar") ? 'class="selected"' : "" ?>><a class="firmalar" href="<?= base_url() ?><?=$meslekUrl?>firmalar"><span></span>Firmalar</a></li>
                <li <?=($this->uri->segment(1)=="makaleler" || $this->uri->segment(2)=="makaleler") ? 'class="selected"' : "" ?>><a class="makaleler" href="<?= base_url() ?><?=$meslekUrl?>makaleler"><span></span>Makaleler</a></li>
              <? /*   <li <?=($this->uri->segment(1)=="videolar" || $this->uri->segment(2)=="videolar") ? 'class="selected"' : "" ?>><a class="videolar" href="<?= base_url() ?><?=$meslekUrl?>videolar"><span></span>Videolar</a></li>  */ ?>
                <li <?=($this->uri->segment(1)=="download" || $this->uri->segment(2)=="download") ? 'class="selected"' : "" ?>><a class="download" href="<?= base_url() ?><?=$meslekUrl?>download"><span></span>Download</a></li>
            </ul>
        </div>
    


    
 