<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");
?>
<div id="fb-root"></div>
<script src="https://connect.facebook.net/tr_TR/all.js#appId=188352007953512&xfbml=1"></script>

<fb:registration 
  fields="[
 {'name':'name'},
 {'name':'email'},
 {'name':'location'},
 {'name':'gender'},
 {'name':'birthday'},
 {'name':'password'},
 {'name':'meslek',      'description':'Mesleğiniz?',              'type':'select',    'options':{'1':'Öğretmen','2':'Doktor'}, 'default':'1'},
 
]" 
  redirect-uri="http://www.e-meslek.net/floginget/"
  width="520">
</fb:registration>
