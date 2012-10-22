<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
   $this->load->helper("date");
?>
<script type="text/javascript">
   
   function itemDelete(id,token){
      var u=confirm('<?php echo lang("Seçmiş olduğunuz makaleyi silmek istediğinize emin misiniz?")?>');
      if(u){
      $("#result").html(resultFormat("pending","<?php echo lang("Siliniyor...") ?> "));
      $.ajax({
         type:'POST',
         url:'<?php echo base_url().url_title($this->meslekname) ?>/admin/makaleler/delete/'+id+'?token='+token,
         dataType:'json',
         success:function(respond){  
            if(respond.success=="true"){
               $("#result").html(resultFormat("success","<?php echo lang("Seçmiş olduğunuz makale silinmiştir.") ?> "));
               setTimeout("window.location='<?=base_url().url_title($this->meslekname)?>/admin/makaleler'",2000);

            }else if (respond.success=="false") {
               $("#result").html(resultFormat("alert","<?php echo lang("Seçmiş olduğunuz makale silinemedi!") ?>"));
            }
         }
      })
      }
   }

</script>
<div id="leftPanel">
    <? require APPPATH."blocks/admin_yetki.php" ?>
</div>
<div id="rightPanel">
   <div id="result"></div>
   <div class="block">
      <div class="head"><?php echo lang("Makaleler") ?>
        <span class="right" style="padding:4px;"><?php echo form_open(base_url().url_title($this->meslekname)."/admin/makaleler/", array("name" => "searchForm", "id" => "searchForm", "method" => "get")); ?>
        <?php echo form_dropdown("active",$this->durum,(isset($_GET["active"]))? $_GET["active"]: "" ) ?>
        <input type="input" name="q" id="q" value="<?= isset($_GET["q"]) ? $_GET["q"] : "" ?>" style="border:1px solid #666666; padding:4px; width:214px; font-size:11px;" placeholder="Makalelerde arama yapın"/>         
        <?php echo form_button(array("content" => lang("Arama"), "class" => "button", "onclick" => "$('#searchForm').submit()")) ?>
        <?php echo form_close() ?></span>   
      </div>
      <table id="example" width="100%" class="display" style="font-size:11px;">
         <thead>
            <tr>
               <th width="50%"><?php echo lang("İsim") ?></th>
               <th width="20%"  ><?php echo lang("Kategori") ?></th>
               <th width="20%"><?php echo lang("Haber Tarihi") ?></th>
               <th width="10%">İşlemler</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach($data as $row) :  ?>
            <tr id="row_<?php echo $row->id ?>">
               <td><b style="color:#2F547E"><?php echo $row->name ?></b></td>
               <td><?php echo $row->categoryname ?></td>
               <td><?php echo dateFormat($row->savedate,'long')?></td>
               <td><a href="<?php echo base_url().url_title($this->meslekname) ?>/admin/makaleler/edit/<?php echo $row->id ?>?token=<?php echo setToken($row->id)?>"><img src="images/icons/bookmark--pencil.png"/></a>
               <a href="javascript:void(0)" onclick="itemDelete('<?php echo $row->id ?>','<?php echo setToken($row->id); ?>')"><img src="images/icons/cross-circle-frame.png"/></a></td>
            </tr>
            <? endforeach;?>
         </tbody>
      </table>
   </div>
   
   
   <?php if (count($data) > 0) { ?>
            <div class="pagination">
                <div style="width:200px; font-size:11px; color:#666666; float:left;">
                    <?php echo lang("Toplam") . " <b style='color:red'>" . $this->mod_makale_model->total_rows . "</b> " . lang("adet") . " " . lang("makale kaydı bulundu!") ?>
                </div>
                <div style="float:left; text-align: right; width:443px;">
                    <?php
                    $this->load->library('pagination');
                    $url = "";
                    $i = 0;
                    if (isset($_GET)) { foreach ($_GET as $k => $v) { $i++; if ($k != "s") $url.=$k . "=" . $v;  $url.=($i != count($_GET)) ? "&" : ""; }}
                    $config['prev_link'] = '&lt;' . lang("Önceki");
                    $config['next_link'] = lang("Sonraki") . '&gt;';
                    $config['page_query_string'] = true;
                    $config['base_url'] = base_url() . $this->uri->uri_string() . "?" . $url;
                    $config['total_rows'] = $this->mod_makale_model->total_rows;
                    $config['per_page'] = 20;
                    $config['query_string_segment'] = "s";
                    $this->pagination->initialize($config);
                    echo $pagination = $this->pagination->create_links();
                    ?>
                </div>

            </div>
        <? } ?>
   
</div>