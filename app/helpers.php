<?php

function is_image($filename){

    $is = @getimagesize($filename);
    if (!$is):
        return false;
    elseif (!in_array($is[2], array(1, 2, 3))):
        return false;
    else:
        return true;
    endif;
}

function hexColor(){

   return '#'.dechex(rand(0, 255)).dechex(rand(0, 255)).dechex(rand(0, 255));
}