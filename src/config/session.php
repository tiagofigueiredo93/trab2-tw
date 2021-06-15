<?php

function requireValidSession($requiresAdmin = false)
{
    $user = $_SESSION['user'];

    if (!isset($user)) {
        header('Location: home.php');
        exit();
        //caso alguma pagina necessite de set admin e o user->is_admin não é admin mostra um erro
    } elseif ($requiresAdmin && !$user->is_admin) {
        addErrorMsg('Acesso negado, necessita de ser administrador!');
        header('Location: day_records.php');
        exit();
    }
}
