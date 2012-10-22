<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

/* Dil Dosyamızı yüklüyoruz
 * ilk parametre admin_lang.php dosyasının yükleneceği gösteriyor.. ikinci parametre ise dili temsil ediyor..
 */
($this->session->userdata("user_lang")=="") ? $this->session->set_userdata("user_lang", $this->config->item("site_language")) : "";
$this->lang->load("admin", $this->session->userdata["user_lang"]);

//Header
require 'header.php';

//Admin Menülerinin yer aldığı sayfa
require 'menu.php';
?>

<div id="content">
    <?php echo $module_output; ?>
</div>

<?php
//Footer
require 'footer.php';
?>