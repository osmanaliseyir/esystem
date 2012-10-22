<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


//
$route['meslekler']  = 'home/home/meslekler';
$route['forumlar']  = 'home/home/page/forumlar';
$route['isbirligi']  = 'home/home/page/isbirligi';
$route['haberler']  = 'home/home/page/haberler';
$route['etkinlikler']  = 'home/home/page/etkinlikler';
$route['ilanlar']  = 'home/home/page/ilanlar';
$route['firmalar']  = 'home/home/page/firmalar';
$route['makaleler']  = 'home/home/page/makaleler';
$route['videolar']  = 'home/home/page/videolar';
$route['download']  = 'home/home/page/download';

//Statik Sayfalar
$route['kullanici-sozlesmesi']  = 'pages/pages/index/kullanici-sozlesmesi';
$route['gizlilik-politikasi']  = 'pages/pages/index/gizlilik-politikasi';
$route['yardim']  = 'pages/pages/index/yardim';
$route['reklam']  = 'pages/pages/index/reklam';
$route['hakkimizda']  = 'pages/pages/index/hakkimizda';
$route['iletisim']  = 'contact/contact/index';


$route['common/(:any)']  = 'common/common/$1';

//Downloads
$route['(:any)-(:any)dk.html']  = 'download/download_controller/category/$2';
$route['(:any)/admin/download/kategoriler/(:any)']="download/download_mod_category/$2";
$route['(:any)/admin/download/kategoriler']="download/download_mod_category/index";
$route['(:any)/admin/download/(:any)']  = "download/download_mod_controller/$2";
$route['(:any)/admin/download']         = "download/download_mod_controller/index";
$route['(:any)/download/(:any)']        = "download/download_controller/$2";
$route['(:any)/download']               = "download/download_controller/index/$1";
$route['(:any)/videolar']               = "video/video/index";
$route['(:any)/meslekler']               = "home/home/meslekler";

//FORUMS

//HABERLER MOD
$route['(:any)/admin/firmalar/kategoriler/(:any)']="firma/modCategory/$2";
$route['(:any)/admin/haberler/kategoriler']="firma/modCategory/index";
$route['(:any)/admin/haberler/(:any)']="firma/modHaber/$2";
$route['(:any)/admin/haberler']="haber/modHaber/index";

//HABERLER MOD
$route['(:any)-(:any)c.html']  = 'firma/firmalar/detay/$2';
$route['(:any)/admin/firmalar/kategoriler/(:any)']="firma/modCategory/$2";
$route['(:any)/admin/firmalar/kategoriler']="firma/modCategory/index";
$route['(:any)/admin/firmalar/(:any)']="firma/modFirma/$2";
$route['(:any)/admin/firmalar']="firma/modFirma/index";
$route['(:any)/firmalar/(:any)']="firma/firmalar/$2";
$route['(:any)/firmalar']="firma/firmalar/index/$1";

//MAKALELER MOD
$route['(:any)-(:any)m.html']  = 'makale/makaleler/detay/$2';
$route['(:any)/admin/makaleler/kategoriler/(:any)']="makale/modCategory/$2";
$route['(:any)/admin/makaleler/kategoriler']="makale/modCategory/index";
$route['(:any)/admin/makaleler/(:any)']="makale/modMakale/$2";
$route['(:any)/admin/makaleler']="makale/modMakale/index";



//FORUM MOD
$route['(:any)/admin/forumlar/(:any)']="forum/modForum/$2";
$route['(:any)/admin/forumlar']="forum/modForum/index";

$route['(:any)-forumlar']  = 'forum/forum/index/$1';
$route['(:any)-(:any)fk.html']  = 'forum/forum/showTopic/$2';
$route['(:any)-(:any)f.html']  = 'forum/forum/subForums/$2';
$route['(:any)konu-ekle/(:any)']  = 'forum/forum/addTopic/$2';
$route['(:any)konu-duzenle/(:any)']  = 'forum/forum/editTopic/$2';
$route["(:any)forumlar/konularim"]='forum/forum/myTopics';
$route["forum/forum/(:any)"]='forum/forum/$1';
$route["forum/forum"]='forum/forum/index';

//KULLANICI MOD
$route['(:any)/admin/kullanicilar/(:any)']="users/modUsers/$2";
$route['(:any)/admin/kullanicilar']="users/modUsers/index";

//İLANLAR
$route['(:any)-(:any)i.html']  = 'ilan/ilanlar/detay/$2';
$route['(:any)/admin/ilanlar/kategoriler/(:any)']="ilan/modCategory/$2";
$route['(:any)/admin/ilanlar/kategoriler']="ilan/modCategory/index";
$route['(:any)/admin/ilanlar/(:any)']="ilan/modIlan/$2";
$route['(:any)/admin/ilanlar']="ilan/modIlan/index";
$route['(:any)/ilanlar/(:any)']="ilan/ilanlar/$2";
$route['(:any)/ilanlar']="ilan/ilanlar/index/$1";
$route['(:any)/admin']="mod/mod/index";





//Kullanıcı
$route["kullanici/(:any)"]='users/users/detay/$1';

//Facebook Login
$route['floginget']  = 'home/home/floginget';
$route['flogin']  = 'home/home/flogin';
$route['ucheck']  = 'home/home/userlogin';


$route['profilim/arkadaslarim/(:any)']  = 'profile/arkadaslarim/$1';
$route['profilim/arkadaslarim']  = 'profile/arkadaslarim/index';

$route['profilim/bildirimler/(:any)']  = 'profile/bildirimler/$1';
$route['profilim/bildirimler']  = 'profile/bildirimler/index';

$route['profilim/mesajlarim/(:any)']  = 'profile/mesajlarim/$1';
$route['profilim/mesajlarim']  = 'profile/mesajlarim/index';

//Profile Actions
$route['profilim/(:any)']  = 'profile/profileController/$1';
$route['profilim']  = 'profile/profileController/index';
$route['profilim/sifre-degistir']  = 'profile/profileController/changepassword';
$route['sifre-kontrol']  = 'profile/profileController/changepasswordCheck';
$route['cikis-yap'] = 'profile/profileController/user_logout';
$route['profilim/fotograf'] = 'profile/profileController/changephoto';

$route['login'] = 'home/home/login';
$route['signup'] = 'home/home/signup';
$route['sifremi-unuttum']  = 'home/home/sifremiunuttum';
$route['users/user_login']='users/users/user_login';

//Forumlar
$route['admin/forum/forumlar/(:any)'] = 'forum/adminForum/$1';
$route['admin/forum/forumlar'] = 'forum/adminForum/index';
$route['admin/forum/altforumlar/(:any)'] = 'forum/adminAltForum/$1';
$route['admin/forum/altforumlar'] = 'forum/adminAltForum/index';

// Haberler
$route['admin/haber/haberler/(:any)'] = 'haber/adminHaber/$1';
$route['admin/haber/haberler'] = 'haber/adminHaber/index';
$route['admin/haber/category/(:any)'] = 'haber/adminCategory/$1';
$route['admin/haber/category'] = 'haber/adminCategory/index';

//İlanlar
$route['admin/ilan/ilanlar/(:any)'] = 'ilan/adminIlan/$1';
$route['admin/ilan/ilanlar'] = 'ilan/adminIlan/index';
$route['admin/ilan/category/(:any)'] = 'ilan/adminCategory/$1';
$route['admin/ilan/category'] = 'ilan/adminCategory/index';

$route['admin/lang/([a-zA-Z_-]+)'] = 'admin/lang/$1';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/check'] = 'admin/check';
$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/logout';


$route['admin/([a-zA-Z_-]+)/(:any)'] = '$1/admin/$2';
$route['admin/([a-zA-Z_-]+)'] = '$1/admin/index';
$route['admin'] = 'admin';
$route['home/(:any)'] = 'home/home/$1';
$route['home'] = 'home';

$route['(:any)-(:any)h.html']  = 'haber/haberler/detay/$2';
$route['(:any)/haberler']="haber/haberler/index/$1";
$route['(:any)/makaleler']="makale/makaleler/index/$1";
$route['(:any)/forumlar']="forum/forum/index/$1";
$route['(:any)']="index/index/index/$1";
$route['default_controller'] = "home";



/* End of file routes.php */
/* Location: ./application/config/routes.php */