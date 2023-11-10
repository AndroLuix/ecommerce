<?php


function intoPublic($link){
    return  __DIR__.'/public/'.$link;
    }
  
    
    function components($root){
        return   include "views/components/".$root.".php" ; 
    }

 