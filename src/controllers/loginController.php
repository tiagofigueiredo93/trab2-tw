<?php

loadModel('Login');
session_start();
$exception = null;

if (count($_POST) > 0) {
    $login = new Login($_POST);
    try {
        //verificação se o utilizador está logado
        $user = $login->checkLogin();
        $_SESSION['user'] = $user;
        //echo "Utilizador {$user->name} logado com sucesso";
        header("Location: day_records.php");
    } catch (AppException $e) {
        $exception = $e;
    }
}


//$_POST array_assoc
loadView('login', $_POST + ['exception' => $exception]);
