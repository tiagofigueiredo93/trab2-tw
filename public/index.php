<?php

//require_once(dirname(__FILE__, 2) . '/src/config/database.php');
require_once(dirname(__FILE__, 2) . '/src/config/config.php');



$uri = urldecode(
    //Para obter só unicamente a parte do URL_PATH que interessa, mesmo tendo parâmetros á frente
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri === '/' || $uri === '' || $uri === '/index.php') {
    $uri = '/loginController.php';
}

require_once(CONTROLLER_PATH . "/{$uri}");
