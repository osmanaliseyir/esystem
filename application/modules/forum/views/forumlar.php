<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<div id="leftPanel">
     <? require APPPATH.'blocks/forumdan_son_konular.php'; ?>
     <? require APPPATH.'blocks/son_uyeler.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href='<?=base_url()?>'>Anasayfa</a></li>
            <li><a href='<?=base_url().url_title($mesleks["name"]) ?>/forumlar'><?=$mesleks["name"]?> Forumu</a></li>
        </ul> 
    </div>
    
    <div style="float:left; width:200px; margin-top:10px;">
        <img src="images/forums.png" style="vertical-align:bottom"/> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Forumlar</span>    
    </div>
    <div style="float:left; width:460px; margin-top:10px;" align="right">
        <input type="input" style="border:1px solid #666666; padding:4px; width:314px; font-size:11px;" placeholder="Forumlarda arama yapın"/>    
    </div>
    <div class="fix"></div>
    <div style="padding-top:4px; margin-top:10px; border-top:1px solid #CCCCCC;">
    <table width="100%" cellpadding="5" style="margin-top:5px;" cellspacing="0" style="">
       <? foreach($data as $row) : ?>
        <tr style="background: #EEEEEE; font-size:12px;">
            <td colspan="4" class="forumRow"><?php echo $row["name"]; ?></td>
        </tr>
        <tr>
            <td class="forumRow2" width="50%">Forum</td>
            <td class="forumRow2" width="10%">Konu</td>
            <td class="forumRow2" width="10%">Mesaj</td>
            <td class="forumRow2" width="30%">Son Konu</td>
        </tr>
        <?
        if(isset($row["subforums"]) && count($row["subforums"])>0){
            foreach($row["subforums"] as $id=>$sub): ?>
        <tr style="border-bottom:1px solid #CCCCCC;">
            <td class="subForumRow"><a href='<?=base_url()?><?=$this->uri->segment(1)?>/forumlar/<?=url_title($sub["name"])?>-<?=$id?>f.html'><?php echo "<b style='color:#2F547E; font-size:12px;'>".$sub["name"]."</b><br><span>".$sub["description"]."</span>"; ?></a></td>
            <td class="subForumRow"><?=$sub["konu"]?></td>
            <td class="subForumRow"><?=$sub["mesaj"]?></td>
            <td class="subForumRow"><?=(isset($sub["sonmesajlink"])) ? "<a href='".$sub["sonmesajlink"]."'>" : ""?>
                <div style="overflow:hidden; display: block; width:200px; height:18px;">
                    <b><?=(isset($sub["sonmesaj"])) ? substr($sub["sonmesaj"],0,100) : ""?></b>
                </div></a><span style='color:#666666; font-size:11px;'><?=(isset($sub["sonmesajyazar"])) ? "<a href='".base_url()."kullanici/".$sub["sonmesajyazarid"]."'>".$sub["sonmesajyazar"]."</a>" : ""?></span></td>
        </tr>
            <? endforeach;
        }
            
            
            ?>
        <tr>
            <td colspan="4"></td>
        </tr>
       <? endforeach; ?>
        
    </table>
    </div>
</div>