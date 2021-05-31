<?php

loadModel('Login');
$exception = null;

if (count($_POST) > 0) {
    $login = new Login($_POST);
    try {
        //verificação se o utilizador está logado
        $user = $login->checkLogin();
        echo "Utilizador {$user->name} logado com sucesso";
    } catch (AppException $e) {
        $exception = $e;
    }
}


//$_POST array_assoc
loadView('login', $_POST + ['exception' => $exception]);
