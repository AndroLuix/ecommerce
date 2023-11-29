<?php

/* $projectPath = realpath(__DIR__);
echo "project path = " . $projectPath;

$publicPath = $_SERVER['DOCUMENT_ROOT'];
echo "<br>public path = " . $publicPath;

$request = $_SERVER['REQUEST_URI'];
echo '<br>Request = ' . $request;

// Imposta il prefisso manualmente
$prefixToRemove = '/ecommerce/';
echo '<br>Prefix to remove = ' . $prefixToRemove;

// Rimuovi il prefisso dalla richiesta
$requestWithoutPrefix = (strpos($request, $prefixToRemove) === 0) ? substr($request, strlen($prefixToRemove)) : $request;
// Rimuovi eventuali barre in eccesso dal percorso della richiesta
$requestWithoutPrefix = trim($requestWithoutPrefix, '/');

echo '<br>requestWithoutPrefix = ' . $requestWithoutPrefix; */

$request = $_SERVER['REQUEST_URI'];
echo $request;
/* $request = str_replace("/ecommerce", "" ,$request);
echo '<br>nu '.$request;
 */

 $requestWithoutPrefix = str_replace("/ecommerce", "", $request);
echo '<br>nu ' . $requestWithoutPrefix;
function INC_($class){
    return include __DIR__.'/inc/'.$class.".php";
}

INC_('init');



function view($root) {
    return __DIR__ . '/views/' . $root . '.php';
}

switch ($requestWithoutPrefix) {
    case '/':
        require view('auth/login');
        break;
    case '/dashboard':
        require view('home/dashboard');
        break;
    case '/register':
        require view('auth/register');
        break;
    case '/register-seller':
        require view('auth/register-seller');
        break;
    default:
        http_response_code(404);
        require view('errors/404');
        break;
}

//echo $requestWithoutPrefix . "<br>";
echo __DIR__ . "<br>";
// Nota: intoPublic('title.js') non è definito nel codice fornito
// echo "into public: " . intoPublic('title.js') . "<br>";

echo view("auth/login");
