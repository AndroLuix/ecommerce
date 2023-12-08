<?php
//server request URL 
$request = $_SERVER['REQUEST_URI'];

echo $request;
//$requestWithoutPrefix = str_replace("/ecommerce/", "", $request);
$requestWithoutPrefix = $request;
echo "<br> <span style='color: blue;'> Route without prefix = " . $requestWithoutPrefix . "</span >";


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
        case '/server-error-500';
            require view('errors/server-error-500');  break;

        
            //per i test
        case '/testorm': require test('orm/testPAGE'); break;
        default:
            http_response_code(404);
            require view('errors/404');
            break;
    }

