<?php

define('PATH_INDEX',__DIR__);

$request = $_SERVER['REQUEST_URI'];
echo $request;

$requestWithoutPrefix = str_replace("/ecommerce", "", $request);
echo '<br>nu ' . $requestWithoutPrefix;

function INC_($class){
    return include __DIR__.'/inc/'.$class.".php";
}

INC_('init');
INC_('router');
callPhpFile('conn');
routeRequest($requestWithoutPrefix);  // Chiamiamo la funzione di routing con il parametro necessario


// FILE PER LE ROOT
 //require __DIR__.'/router.php';

// connessione al DB



 // FILE PER LA CONNESSIONE
 //require __DIR__.'';

function view($root) {
    return __DIR__ . '/views/' . $root . '.php';
}

echo '<br>'.__DIR__ . "<br>";

echo '<BR>'.view("auth/login");
