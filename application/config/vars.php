<?php
defined("BASEPATH") or die("Direkt Erişim Yok!");

$this->seciniz=array(""=>"Seçiniz");
$this->cinsiyetler = array(""=>"Seçiniz","1"=>"Erkek","2"=>"Kadın");
$this->durum = array(""=>"Seçiniz","1"=>"Aktif","0"=>"Pasif");

//Doğum Tarihi
$dtgun[]="Seçiniz";
$dtyil[]="Seçiniz";
for ($i=1; $i<=31;$i++ ){ $dtgun[$i]=$i; }
for ($i=1940; $i<=2010;$i++ ){ $dtyil[$i]=$i;}

$this->dtgun=$dtgun;
$this->dtyil=$dtyil;
$this->dtay=array(""=>"Seçiniz","1"=>"Ocak","2"=>"Şubat","3"=>"Mart","4"=>"Nisan","5"=>"Mayıs","6"=>"Haziran","7"=>"Temmuz","8"=>"Ağustos","9"=>"Eylül","10"=>"Ekim","11"=>"Kasım","12"=>"Aralık");
$this->iller=array("Seçiniz","Adana","Adıyaman","Afyon","Ağrı","Amasya","Ankara","Antalya","Artvin","Aydın","Balıkesir","Bilecik","Bingöl","Bitlis","Bolu","Burdur","Bursa","Çanakkale","Çankırı","Çorum","Denizli","Diyarbakır","Edirne","Elazığ","Erzincan","Erzurum","Eskişehir","Gaziantep","Giresun","Gümüşhane","Hakkari","Hatay","Isparta","İçel(Mersin)","İstanbul","İzmir","Kars","Kastamonu","Kayseri","Kırklareli","Kırşehir","Kocaeli","Konya","Kütahya","Malatya","Manisa","Kahramanmaraş","Mardin","Muğla","Muş","Nevşehir","Niğde","Ordu","Rize","Sakarya","Samsun","Siirt","Sinop","Sivas","Tekirdağ","Tokat","Trabzon","Tunceli","Şanlıurfa","Uşak","Van","Yozgat","Zonguldak","Aksaray","Bayburt","Karaman","Kırıkkale","Batman","Şırnak","Bartın","Ardahan","Iğdır","Yalova","Karabük","Kilis","Osmaniye","Düzce");

?>
