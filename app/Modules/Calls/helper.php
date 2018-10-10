<?php

/**
 *	Calls Helper  
 */

if(!function_exists('isBright')){
    function isBright($color){
        return hexdec(substr($color,0,2))+hexdec(substr($color,2,2))+hexdec(substr($color,4,2)) > 382;
    }
}