<?php

session_start();

//requer uma sessão válida
requireValidSession(true);

$exception = null;

$userData = [];


if (count($_POST) === 0 && isset($_GET['update'])) {
    $user = User::getOne(['id' => $_GET['update']]);
    $userData = $user->getValues();
    $userData['password'] = null;

    //caso haja alguma requisição via POST 
} elseif (count($_POST) > 0) {
    try {
        $dbUser = new User($_POST);
        //verificar se o user a inserir já tem id definido, e caso tenha é feito um update
        if ($dbUser->id) {
            $dbUser->update();
            addSuccessMsg('Funcionário editado com sucesso!');
            header('Location: users.php');
            exit();
        } else {
            //caso não tenha id é feito um insert 
            $dbUser->insert();
            addSuccessMsg('Funcionário registado com sucesso!');
        }
        $_POST = [];
    } catch (Exception $e) {
        $exception = $e;
    } finally {
        $userData = $_POST;
    }
}



loadTemplateView('save_user', $userData + [
    'exception' => $exception
]);
