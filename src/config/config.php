<?php

//DEFINIR O FUSO HORÁRIO
date_default_timezone_set('Portugal');
setlocale(LC_TIME, 'pt_PT', 'pt_PT.utf-8', 'portuguese');

//Pastas do meu projeto
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));

//DATABASE
require_once(realpath(dirname(__FILE__) . '/database.php'));
