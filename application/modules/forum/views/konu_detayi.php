<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
$this->load->helper("date");
?>
<script type="text/javascript">
    function saveReply(){
        if($("#description").val()==""){
         $("#result").html(resultFormat('warning','Cevap İçeriğini boş bırakamazsınız!'));
         return false;   
        }
        
        $("#result").html(resultFormat('pending','Cevabınız Kaydediliyor...'));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>forum/forum/saveReply/<?= $data["konu"]->id ?>',
            data:$("#replyForm").serialize(),
            dataType:'json',
            success:function(respond){
                if(respond){
                    if(respond.success=="true"){
                        $("#description").val("");
                        $("#result").html(resultFormat('success',"Cevabınız Başarıyla Kaydedildi."));
                        window.location=''+respond.link+'';
                    } else {
                        $("#result").html(resultFormat('alert',''+respond.msg+''));
                    }             
                }
            }
        });
        
        
    }
    
    function deleteTopic(id,token){
        var u=confirm("Mesajınızı silmek istediğinize emin misiniz?");
        if(u){
        $("#result_"+id+"").html(resultFormat('pending','Mesajınız Siliniyor...'));
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>forum/forum/deleteTopic/'+id+'?token='+token,
            data:'',
            dataType:'json',
            success:function(respond){
                if(respond){
                    if(respond.success=="true"){
                      
                        $("#result_"+id+"").html(resultFormat('success',"Mesajınız Başarıyla Silinmiştir."));
                        window.location=''+respond.link+'';
                    } else {
                        $("#result_"+id+"").html(resultFormat('alert',''+respond.msg+''));
                    }             
                }
            }
        });
        }
    }

</script>
<div id="leftPanel">
     <? require APPPATH.'blocks/forumdan_son_konular.php'; ?>
     <? require APPPATH.'blocks/son_uyeler.php'; ?>
</div>
<div id="rightPanel">
    <div class="pageTitle">
        <ul>
            <li><a href='<?= base_url() ?>'>Anasayfa</a></li>
            <li><a href='<?= base_url() . $data["meslek"]["url"] ?>/forumlar'><?= $data["meslek"]["name"] ?> Forumu</a></li>
            <li><a href='javascript:void(0)'><?= $data["forum"]["name"] ?></a></li>
            <li><a href='<?= base_url() . $data["meslek"]["url"] ?>/forumlar/<?= url_title($data["altforum"]["name"]) ?>-<?= $data["altforum"]["id"] ?>f.html'><?= $data["altforum"]["name"] ?></a></li>
        </ul> 
    </div>
    
    <div style="float:left; width:200px; margin-top:10px;">
        <img src="images/forums.png" style="vertical-align:bottom"/> <span style="font-size:18px; font-weight: bold; letter-spacing: -1px; color:#333333;">Forumlar</span>    
    </div>
    <div style="float:left; width:460px; margin-top:10px;" align="right">
        <input type="input" style="border:1px solid #666666; padding:4px; width:314px; font-size:11px;" placeholder="Forumlarda arama yapın"/>    
    </div>
    <div class="fix"></div>
    <div style=" margin-top:10px; border-top:1px solid #CCCCCC;">
    
    <div class="forumkonu">
        <span style="font-size:18px; font-weight: bold; color:#2F547E;"><?= $data["konu"]->name ?></span>
        <div align="right">
            <a href='<?=base_url().$this->uri->uri_string()?>#reply'><img src="images/cevap_yaz.jpg"/></a>
            <a href='<?= base_url() ?><?=$data["meslek"]["url"]?>/forumlar/konu-ekle/<?= $data["altforum"]["id"] ?>'><img src="images/yeni_konu.jpg"/></a>
        </div>
    </div>
       
    <? foreach ($data["mesajlar"] as $mesaj): ?>
        <div class='forummesaj'>
             <div class='forummesajdate'><?php echo dateFormat($mesaj->savedate, "long"); ?></div>
             <div class="forummesajbuttons">
                 <? if($mesaj->user_id==$this->session->userdata("user_id")){ ?>
                 <div id="result_<?=$mesaj->id?>" class="forumresult"></div>
                 <a href="<?=base_url()?><?=$data["meslek"]["url"]?>/forumlar/konu-duzenle/<?=$mesaj->id?>?token=<?=setToken($mesaj->id)?>"><img src="images/icons/bookmark--pencil.png"/></a>
                 <a href="javascript:void(0)" onclick="deleteTopic(<?=$mesaj->id?>,'<?=setToken($mesaj->id)?>')"><img src="images/icons/cross-circle-frame.png"/></a>
                 <? } ?>
             </div>
            <div class='forummesajleft'>
                <? if($mesaj->image!="" && file_exists("public/images/user/".$mesaj->user_id."/thumb/".$mesaj->image."")){
                    echo "<img style='padding:1px; border:1px solid #CCCCCC;' src='".base_url()."public/images/user/".$mesaj->user_id."/thumb/".$mesaj->image."'>";
                } else {
                    echo "&nbsp;";
                }?>
            </div>
            <div class='forummesajright'>
                <div class='forummesajauthor'><b style="color:#2F547E;"><a href='<?=base_url()?>kullanici/<?=$mesaj->user_id?>'><?php echo $mesaj->adsoyad; ?></a></b><br/>
                <span><?php echo $mesaj->meslek; ?></span><br/></div>
                <div class='forummesajdescription'> <?php echo nl2br($mesaj->description); ?></div>
            </div>      
        </div>
    <? endforeach; ?>
    
    
    <?php if (count($data["mesajlar"]) > 0) { ?>
                    <div class="pagination">
                        <div style="width:200px; font-size:11px; color:#666666; float:left;">
                            <?php echo lang("Toplam") . " <b style='color:red'>" . $this->forum_model->total_rows . "</b> " . lang("adet") . " " . lang("mesaj bulundu!") ?>
                        </div>
                        <div style="float:left; text-align: right; width:443px;">
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
                            $config['total_rows'] = $this->forum_model->total_rows;
                            $config['per_page'] = 10;
                            $config['query_string_segment'] = "s";

                            $this->pagination->initialize($config);
                            echo $pagination = $this->pagination->create_links();
                            ?>
                        </div>

                    </div>
<? } ?>
    
    
    <a name="reply"></a>
    <? 
    $user_id=$this->session->userdata("user_id");
    if($user_id){
    ?>
            <div class='forummesaj'>
            <div class='forummesajleft'>
                <? if($this->session->userdata("user_image")!="" && file_exists("public/images/user/".$this->session->userdata("user_id")."/thumb/".$this->session->userdata("user_image")."")){
                    echo "<img  src='".base_url()."public/images/user/".$this->session->userdata("user_id")."/thumb/".$this->session->userdata("user_image")."'>";
                } else {
                    echo "&nbsp;";
                }?>
            </div>
            <div class='forummesajright'>
                <div class='forummesajauthor'><b style="color:#2BA6D5;"><?php echo $this->session->userdata("user_adsoyad"); ?></b><br/>
                <span><?php echo $this->session->userdata("user_meslekname"); ?></span><br/></div>
                <div class='forummesajdescription'> 
                <?php echo form_open("",array("id"=>"replyForm","name"=>"replyForm")); ?>
                <?php echo form_textarea(array("id"=>"description","name"=>"description","style"=>"width:590px; border:1px solid #999999; padding:3px; height:50px; font-size:12px; font-family:Arial;","placeholder"=>"Cevabınızı Yazınız")); ?>
                    <a href="javascript:void(0)" onclick="saveReply()"><img src="images/kaydet.jpg"/></a>
                    <div style="float:right; width:430px;" id="result"></div>
                <?php echo form_close() ?>
                </div>
            </div>
            <div style="">
                
            </div>
        </div>
           
    <?
    } else {
        echo "<div class='warning'>Cevap yazabilmek için üye girişi yapmanız gerekiyor.</div>";
    }
    ?>
    </div>
</div>