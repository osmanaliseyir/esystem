<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

if (!function_exists('template_url')) {

   /**
    * Verilen template ile ilgili (css, js, resim) vs.
    * icerigi barindiran klasorun url'sini doner.
    * 
    * @param type $template_name
    * @param type $uri
    * @return type 
    */
   function template_url($template_name = 'site', $uri = '') {
      $CI = & get_instance();
      $new_uri = ($template_name != "") ? "/themes/" . $template_name : "/themes/" . $CI->config->item("site_theme");
      if ($uri != '') {
         $new_uri .= '/' . $uri;
      }
      return $CI->config->base_url($new_uri) . '/';
   }

   function setToken($id,$random="") {
      $CI = & get_instance();
      $base = md5($id . $CI->config->item("encryption_key").$random);
      return $base;
//return base64_encode($base);
   }
   
   function tokenCheck($id,$token=""){
        if (isset($id) && $id != "") {
         //İd Kontrolü
         (isset($_GET["token"]) && $token == $_GET["token"]) ? "" : show_404(); } else { show_404(); } 
   }
  

}