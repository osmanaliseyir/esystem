<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo (isset($title) && $title != "") ? $title : $this->config->item("site_title") ?></title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="<?php echo $this->config->item("site_author") ?>">
        <meta name="description" content="<?php echo $this->config->item("site_description") ?>">
        <meta name="keywords" content="<?php echo $this->config->item("site_keywords") ?>">
        <base href="<?php echo template_url('home'); ?>"/>
        <link rel="stylesheet" href="css/default.css"/>
        <!-- LANGUAGE -->     
        <script type="text/javascript" src="<?php echo base_url() . APPPATH ?>language/<?php echo $this->session->userdata["user_lang"] ?>/lang.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-placeholder/placeholder.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>public/js/custom.js"></script>

        <!-- JQUERY UI -->
        <script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-ui/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-ui/jquery-ui.css"/>

        <!-- JQUERY TOOLTİP -->
        <script type="text/javascript" src="<?php echo base_url() ?>externals/jquery-tooltip/jquery.tipsy.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>externals/jquery-tooltip/tipsy.css"/>
    </head>
    <body>


        <?php require 'header.php'; ?>
        <div id="wrapper">
        <div id="body-wrapper">
            <?php echo $module_output; ?>
        </div>
            <?php require 'footer.php'; ?>
        
        </div>

    </body>
</html>
