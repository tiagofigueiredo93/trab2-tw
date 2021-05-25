<?php

//require_once(dirname(__FILE__, 2) . '/src/config/database.php');
require_once(dirname(__FILE__, 2) . '/src/config/config.php');
require_once(dirname(__FILE__, 2) . '/src/models/User.php');

$user = new User(['name' => 'tiago', 'email' => 'tiago@gmail.com']);
print_r($user);
$user->email = 'novoemail@gmail.com';
echo '<br>';
print_r($user);
echo '<br>';
//ler o email
print_r($user->email);
