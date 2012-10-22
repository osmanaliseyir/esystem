<?php (defined('BASEPATH')) or exit('No direct script access allowed');

if (!function_exists('dateFormat'))
{
    /**
     * Date formatını türkçeye çevirir
     * 
     * @param string $date
     * @param type $type
     * @return string 
     */
    function dateFormat($date,$type="short")
    {

        $aylar=array("1"=>"Ocak","2"=>"Şubat","3"=>"Mart","4"=>"Nisan","5"=>"Mayıs","6"=>"Haziran","7"=>"Temmuz","8"=>"Ağustos","9"=>"Eylül","10"=>"Ekim","11"=>"Kasım","12"=>"Aralık");
        $month=date("m",strtotime($date));
        $month=$aylar[intval($month)];
       
        if(date("Y-m-d")==date("Y-m-d",strtotime($date))){
            return "Bugün"." ".date("H:i",strtotime($date)) ;
        }
        
       if($type=="short"){
          return date("d",strtotime($date))." ".$month." ".date("Y",strtotime($date));
       } 
       return date("d",strtotime($date))." ".$month." ".date("Y",strtotime($date))." ".date("H:i",strtotime($date));
       
    }
    
    function encodeDate($date){
        $arg=explode("/",$date);
        $day=$arg[0];
        $month=$arg[1];
        $year=$arg[2];
        return $year."-".$month."-".$day;
        
    }
    
    function decodeDate($date){
        $arg=explode("-",$date);
        $year=$arg[0];
        $month=$arg[1];
        $day=$arg[2];
        return $day."/".$month."/".$year;
    }
    
}