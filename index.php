<?php

$request = $_SERVER['REQUEST_URI'];
echo $request;
$requestWithoutPrefix = str_replace('/', '', $request);

function INC_($class){
    return include __DIR__.'/inc/'.$class.".php";

}

INC_('init');



function view($root) {
    return __DIR__ . '/views/' . $root . '.php';
}

switch ($requestWithoutPrefix) {
    case '':
        require view('auth/login');
        break;
    case 'dashboard':
        require view('home/dashboard');
        break;
     case 'register':
        require view('auth/register'); break;
    case 'register-seller':
    require view('auth/register-seller'); break;
}


echo $requestWithoutPrefix ."<br>";
echo __DIR__ ."<br>";
echo "into public: ". intoPublic('title.js') ."<br>" ;

echo view("auth/login");