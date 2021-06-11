<?php
session_start();

//requer uma sessão válida
requireValidSession();


$date = (new DateTime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

/* //buscar o user á sessão
$user = $_SESSION['user'];
//registos do utilizador
$records = WorkingHours::loadFormUserAndDate($user->id, date('Y-m-d')); */

loadTemplateView('day_records', ['today' => $today,]);
