<?php

echo PATH_INDEX;
function INC_($file){
    return require_once $file.".php";
}




function css($link){
    return PATH_INDEX.'/public/css/'.$link.'css';
}

function js($link){
    return PATH_INDEX.'/public/js/'.$link.'js';
}

function components($root){
    return include PATH_INDEX."/views/components/".$root.".php";
}

function callPhpFile($root){
    return include PATH_INDEX .'/'.$root.".php";
}

function includeClass($class){
    return include PATH_INDEX.'/classes/'.$class.'.php';
}

function view($root) {
    return PATH_INDEX . '/views/' . $root . '.php';
}

includeClass('database/ManagementDatabase');

use Management\ManagementDatabase  ;

$dbInstance = new ManagementDatabase();