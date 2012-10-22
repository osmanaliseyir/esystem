<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="fix"></div>
      <div id="footer" style="padding-top:4px;">
         <div class="block">
            <div class="head"><h3>&copy; <?php echo $this->config->item("site_link") ?>  2011-<?= date("Y") ?></h3></div>

            <div style="padding:10px; font-size:11px;">
               <?php echo $this->config->item("site_footer") ?>
            </div>
            <div id="validators">
                <a href="http://validator.w3.org/check?uri=referer"><img src="images/icon_xhtml.png"/></a> 
                <a href="http://jigsaw.w3.org/css-validator/check?uri=referer"><img src="images/icon_css.png"/></a>
            </div>
         </div>
      </div>

   </body>
</html>
