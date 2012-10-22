<?php

if (!function_exists('openBlock'))
{
    function openBlock($title,$type='grey',$right=""){
        $data='<div class="blocktop'.$type.'"><span>'.$title.'</span>';
        if($right!=""){
            $data.="<span class='right'>".$right."</span>";
        }
        $data.='</div>';
        $data.='<div class="blockcontent'.$type.'">';
        return $data;
    }
}


if (!function_exists('closeBlock'))
{
    function closeBlock($type='grey'){
        $data='</div>';
        $data.='<div class="blockbottom'.$type.'"></div>';
        return $data;
    }
}

  
?>
