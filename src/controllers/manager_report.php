<?php
session_start();

//requer uma sessão válida
requireValidSession(true);

$activeUsersCount = User::getActiveUsersCount();

//quantidade de funcionários ausentes
$absentUsers = WorkingHours::getAbsentUsers();

//quantidade de horas trabalhas naquele mês em segundos
$yearAndMonth = (new DateTime())->format('Y-m');
$seconds = WorkingHours::getWorkedTimeInMonth($yearAndMonth);

//explode para me separar os valores com dois pontos e passar a string como parametro
//explode transforma num array [0] -> horas [1]->minutos [2]->segundos
$hoursInMonth =  explode(':', getTimeStringFromSeconds($seconds))[0];

loadTemplateView('manager_report', [
    'activeUsersCount' => $activeUsersCount,
    'absentUsers' => $absentUsers,
    'hoursInMonth' => $hoursInMonth

]);
