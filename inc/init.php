<?php

function css($link){
    return  __DIR__.'/public/css/'.$link.'css';
    }
    
    function js($link){
        return  __DIR__.'/public/js/'.$link.'js';
        }
      
    
    function components($root){
        return   include "views/components/".$root.".php" ; 
    }

    function callPhpFile($root){
        return  include PATH_INDEX .'/'.$root.".php";
    }

 