<?php

define('PATH_INDEX',__DIR__);

define("DATABASE","ecommerce");
define("HOSTNAME", "localhost");
define("USERNAME","root");
define("PASSWORD","");

//use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('output.log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');