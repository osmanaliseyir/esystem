<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<div id="footer" style="margin:auto; width:994px; font-size:11px;">
        <div style="border:1px solid #CCCCCC; width:972px; display: inline-block; padding:10px; margin-top:5px; background: #FFFFFF;">
            <div style="float:left; width:200px; line-height: 20px; margin-right:20px;">
                <b style="display:block; padding-bottom: 5px; border-bottom:1px solid #CCCCCC;">Popüler Meslekler</b>
                 <ul class="list">
                <?
                $query=$this->db->query("SELECT name,count(site_users.id) as sayi FROM site_meslek INNER JOIN site_users ON site_meslek.id=site_users.meslek GROUP BY site_meslek.id ORDER BY sayi DESC LIMIT 0,5 ");
                 foreach ($query->result() as $row) :?>
               
                    <li><img src="images/icons/tick-small.png"/> <a href="<?=base_url().url_title($row->name)?>"><?=$row->name?></a></li>
                    <? endforeach; ?>
                </ul>
            </div>
            
            <div style="float:left; width:200px; line-height: 20px; margin-right:20px;">
                <b style="display:block; padding-bottom: 5px; border-bottom:1px solid #CCCCCC;">Son Eklenen Meslekler</b>
                 <ul class="list">
                <?
                $query=$this->db->query("SELECT name FROM site_meslek ORDER BY id DESC LIMIT 0,5 ");
                 foreach ($query->result() as $row) :?>
               
                    <li><img src="images/icons/tick-small.png"/> <a href="<?=base_url().url_title($row->name)?>"><?=$row->name?></a></li>
                    <? endforeach; ?>
                </ul>
            </div>



      
    </div>
</div>
