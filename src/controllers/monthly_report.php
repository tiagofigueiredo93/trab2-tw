<?php
session_start();

//requer uma sessão válida
requireValidSession();

//
$currentDate = new DateTime();

$user = $_SESSION['user'];

/* registries vai obter dentro de WorkingHours o getMonthlyReport (relatorio mensal) do user atual e 
peguei na hora atual para ir buscar o mês corrente */
$registries = WorkingHours::getMonthlyReport($user->id, $currentDate);

//Relatório (dados para mostrar na interface)  
$report = [];
//contador para contar os dias da semana trabalhados  
$workday = 0;
//somar horas trabalhas pelos funcionários
$sumOfWorkedTime = 0;

//pegar no ultimo dia 
$lastDay = getLastDayOfMonth($currentDate)->format('d');


for ($day = 1; $day <= $lastDay; $day++) {
    //sprintf para obter o zero antes dos números que não possuem duas casas decimais
    $date = $currentDate->format('Y-m') . '-' . sprintf('%02d', $day);
    $registry = $registries[$date];

    //verifiacar se é um dia de trabalho, se for contar
    if (isPastWorkday($date)) $workday++;

    //Se ecistir registo.
    if ($registry) {
        //somar 
        $sumOfWorkedTime += $registry->worked_time;
        //guarda os registry no array report
        array_push($report, $registry);
    } else {
        //caso não seja dia de trabalho ou dia no passado, é necessário igualar a zero worked_time
        array_push($report, new WorkingHours([
            'work_date' => $date,
            'worked_time' => 0
        ]));
    }
}

$expectedTime = $workday * DAILY_TIME;
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));
//caso o valor seja positivo colocar um mais, quando esteja a dever horas colocar negativo
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';


loadTemplateView('monthly_report', [
    'report' => $report,
    'sumOfWorkedTime' => $sumOfWorkedTime,
    'balance' => "{$sign}{$balance}"
]);
