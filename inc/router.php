<?php
function routeRequest($requestWithoutPrefix)
{
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
}
echo "<br> <style='color: #7FFF00;'> Route with prefix = " . $requestWithoutPrefix . "</style>";
