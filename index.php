<?php

define('PATH_INDEX',__DIR__);

require_once __DIR__ . '/vendor/autoload.php';


//i moduli di inizializzazione (non cambiare mai l'ordine)
include 'inc/config.php'; //file con all'interno le definizioni

include 'inc/init.php';
include 'router.php';

