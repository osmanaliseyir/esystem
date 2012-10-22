<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account {

    public $ci;
    public $user_id;

    function __construct() {
        $this->ci = &get_instance();
    }

}

?>
