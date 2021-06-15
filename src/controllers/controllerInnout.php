<?php
session_start();

//verificar sessão válida
requireValidSession();



//buscar o user á sessão
$user = $_SESSION['user'];
//registos do utilizador
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));


//try para fazer o tratamento de inserção do TIME quando "success" ou caso seja "error" lançar uma exception
try {


    //hora atual e transformar numa string
    $currentTime = strftime('%H:%M:%S', time());

    if($_POST['forcedTime']){
        $currentTime = $_POST['forcedTime'];
    }
    $records->controllerInnout($currentTime);
    addSuccessMsg('Presença marcada com sucesso!');
} catch (AppException $e) {
    addErrorMsg($e->getMessage());
}

//redericionar para day_records
header('Location: day_records.php');
