<?php
session_start();

//requer uma sessão válida
requireValidSession();

//
$currentDate = new DateTime();

$user = $_SESSION['user'];
//ID do utilizador
$selectedUserId = $user->id;
$users = null;
//Para verificar se o utilizador é admin
if ($user->is_admin) {
    $users = User::get();
    //caso no post venha algum utilizador do post sem ser o que está logado. Caso não nada no post utilizo o utilizador selecionado 
    $selectedUserId = $_POST['user'] ? $_POST['user'] : $user->id;
}




//selecionar ANO e MÊS
$selectPeriod = $_POST['period'] ? $_POST['period'] : $currentDate->format('Y-m');
$periods = [];

// Para mostrar os ultimos 2 anos mais o atual
for ($yearDiff = 0; $yearDiff <= 2; $yearDiff++) {
    //subtração com o ano atual
    $year = date('Y') - $yearDiff;

    for ($month = 12; $month >= 1; $month--) {

        $date = new DateTime("{$year}-{$month}-1");
        // periodos
        $periods[$date->format('Y-m')] = strftime('%B de %Y', $date->getTimestamp());
    }
}


/* registries vai obter dentro de WorkingHours o getMonthlyReport (relatorio mensal) do user atual e 
peguei na hora atual para ir buscar o mês corrente */
$registries = WorkingHours::getMonthlyReport($selectedUserId, $selectPeriod);

//Relatório (dados para mostrar na interface)  
$report = [];
//contador para contar os dias da semana trabalhados  
$workday = 0;
//somar horas trabalhas pelos funcionários
$sumOfWorkedTime = 0;

//Para atualizar o mês com o form
$selectDate = (new DateTime($selectPeriod));
//pegar no ultimo dia 
$lastDay = getLastDayOfMonth($selectDate)->format('d');


for ($day = 1; $day <= $lastDay; $day++) {
    //sprintf para obter o zero antes dos números que não possuem duas casas decimais
    $date = $selectDate->format('Y-m') . '-' . sprintf('%02d', $day);
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
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),
    'balance' => "{$sign}{$balance}",
    'selectPeriod' => $selectPeriod,
    'periods' => $periods,
    'selectedUserId' => $selectedUserId,
    'users' => $users,
]);
