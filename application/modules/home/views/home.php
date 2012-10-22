<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="leftPanel">
    <div style="padding:10px;">
    <?
    $query = $this->db->query("SELECT id FROM site_meslek");
$query2 = $this->db->query("SELECT id FROM site_users");
?>
     <h1 class="anasayfaH1">Hakkımızda</h1>
<p style="line-height:24px; font-size:14px;">
    Meslektaşlarınıza ulaşmanızın en kolay yolu e-meslek. Sitemizde meslektaşlarınızı bulabilecek, onlarla sohbet edebilecek, işbirliği kurabileceksiniz.<br><br>
    Sitemizde toplam <b><?= $query->num_rows() ?></b> meslekte <b><?= $query2->num_rows() ?></b> üyemiz bulunmaktadır.<br> Sizde meslektaşlarınız arasındaki yerinizi alın.</p>
</div></div>
<div id="rightPanel">
    <img src="images/meslekler.jpg"/>
</div>