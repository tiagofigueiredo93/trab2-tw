<?php

session_start();

//requer uma sessão válida
requireValidSession(true);

$exception = null;
if (isset($_GET['delete'])) {
    try {
        User::deleteById($_GET['delete']);
        addSuccessMsg('Funcionário excluído com sucesso!');
    } catch (Exception $e) {
        if (stripos($e->getMessage(), 'FOREIGN KEY')) {
            addErrorMsg('Não é possível excluir este funcionário com horas no banco de dados!');
        } else {
            $exception = $e;
        }
    }
}

$users = User::get();
foreach ($users as $user) {
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');

    if ($user->end_date) {

        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }
}

loadTemplateView('users', [
    'users' => $users,
    'exception' => $exception
]);
