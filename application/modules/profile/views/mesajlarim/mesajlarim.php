<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper(array("form", "date"));
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>externals/jquery-datatables/jquery.datatable.css"/>
<script type="text/javascript">
    function itemDelete(id,token){
        var u=confirm('<?php echo lang("Seçmiş olduğunuz mesajı silmek istediğinize emin misiniz?") ?>');
        if(u){
            $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
            $.ajax({
                type:'POST',
                url:'<?php echo base_url() ?>profilim/mesajlarim/delete/'+id+'?token='+token,
                dataType:'json',
                success:function(respond){  
                    if(respond.success=="true"){
                        $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz mesaj silinmiştir.") ?> "));
                        setTimeout('window.location=\'<?= base_url() ?>profilim/mesajlarim\'',2000);
                    }else if (respond.success=="false") {
                        $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz mesaj silinemedi!") ?>"));
                    }
                }
            }); 
        }
    }

</script>
<div id="leftPanel">
    <? require APPPATH . 'blocks/profilim.php'; ?>   

</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href="<?= base_url() ?>">Anasayfa</a></li>
            <li><a href="<?= base_url() ?>profilim">Profilim</a></li>
            <li>Mesajlarım</li>
        </ul>
    </div>

    <div style="float:left; width:200px; margin-top:10px;">
        <img src="images/mail.png" style="vertical-align:bottom"> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Mesajlarım</span>    
    </div>
    <div style="float:left; width:460px; margin-top:10px;" align="right">
        <button class="button" onclick="window.location='<?= base_url() . "profilim/mesajlarim/add" ?>'"><img src="images/yeni_mesaj.png"/> Yeni Mesaj</button>
        <input type="input" style="border:1px solid #666666; padding:4px; width:314px; font-size:11px;" placeholder="Mesaj içeriğinde arama yapın"/>    
    </div>
    <div class="fix"></div>
    <div id="result" style="margin-top:5px;"></div>
    <div style="margin-top:10px; border-top:1px solid #CCCCCC;">
        <?
        if (count($data) > 0) {
            ?>
            <table id="messageTable" class="display" width="100%" style="border-top:1px solid #EEEEEE; font-size:11px;" cellpadding="4" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php echo lang("Mesaj Başlığı") ?></th>
                        <th><?php echo lang("Gönderen") ?></th>
                        <th><?php echo lang("Mesaj Tarihi") ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr id="row_<?= $row->id ?>" style="<? echo ($row->read == 1) ? "" : "background:#F7F7F7; font-weight:bold" ?>">
                            <td width="30%"><a style="color:#333333" href="<?= base_url() ?>profilim/mesajlarim/show/<?= $row->id ?>?token=<?= setToken($row->id) ?>"><?php echo $row->name ?></a></td>
                            <td width="20%"><a href="<?= base_url() ?>kullanici/<?= $row->from ?>"><?php echo $row->sender ?></a></td>
                            <td width="20%"><?php echo dateFormat($row->savedate, "long") ?></td>
                            <td width="5%"><a href="javascript:void(0)" onclick="itemDelete('<?= $row->id ?>','<?= setToken($row->id) ?>')"><img src="images/icons/cross-circle-frame.png"/></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?
        }else {
            echo "<div class='warning'>Henüz mesajınız bulunmamaktadır.</div>";
        }
        ?>
    </div>

    <?php if (count($data) > 0) { ?>
        <div class="pagination">
            <div style="width:200px; font-size:11px; color:#666666; float:left;">
                <?php echo lang("Toplam") . " <b style='color:red'>" . $this->mesaj_model->total_rows . "</b> " . lang("adet") . " " . lang("mesaj bulundu!") ?>
            </div>
            <div style="float:left; text-align: right; width:440px;">
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
                $config['total_rows'] = $this->mesaj_model->total_rows;
                $config['per_page'] = 20;
                $config['query_string_segment'] = "s";

                $this->pagination->initialize($config);
                echo $pagination = $this->pagination->create_links();
                ?>
            </div>

        </div>
    <? } ?>

</div>
</div>
</div>
