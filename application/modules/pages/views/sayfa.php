<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<div id="leftPanel">
   
</div>
<div id="rightPanel">
    <div class="pageTitle" style="">
    <ul>
        <li><a href="<?= base_url() ?>">Anasayfa</a></li>
        <li><a href="<?= base_url() ?><?=$data->urlname?>"><?=$data->name;?></a></li>
    </ul>
</div>
    
        <div style="padding:10px; font-size:13px; line-height: 20px;">
            <b><?php echo $data->name?></b><hr/>
            <?php echo $data->description ?>
        </div>
</div>
