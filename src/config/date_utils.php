<?php

//Função para passar um date e depois retorna um DateTime
function getDateAsDateTime($date)
{
    //verificar se recebi uma string, chamo o construtor datetime, se não retorno $date
    return is_string($date) ? new DateTime($date) : $date;
}

//caso 6 ou 7 o dia está no fim de semana
function isWeekend($date)
{
    $inputDate = getDateAsDateTime($date);
    return $inputDate->format('N') >= 6;
}

//comparar se uma data é maior que a outra
function isBefore($date1, $date2)
{
    $inputDate1 = getDateAsDateTime($date1);
    $inputDate2 = getDateAsDateTime($date2);
    return $inputDate1 <= $inputDate2;
}

//obter o dia seguinte
function getNextDay($date)
{
    $inputDate = getDateAsDateTime($date);
    $inputDate->modify('+1 day');

    return $inputDate;
}


function sumIntervals($interval1, $interval2)
{
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->add($interval2);
    //diferença entre os dois intervalos
    return (new DateTime('00:00:00'))->diff($date);
}

function subtractIntervals($interval1, $interval2)
{
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->sub($interval2);
    //diferença entre os dois intervalos
    return (new DateTime('00:00:00'))->diff($date);
}


//obter um intevalo de tempo entre dois valores
function getDateFromInterval($interval)
{
    return new DateTimeImmutable($interval->format('%H:%i:%s'));
}

//Passar uma string e gerar um DateTime
function getDateFromString($string)
{
    //obter uma data apartir de uma string
    return DateTimeImmutable::createFromFormat('H:i:s', $string);
}

//Buscar o primeiro dia do mês passado por parâmetro
function getFirstDayOfMonth($date)
{
    //getTimestamp
    $time = getDateAsDateTime($date)->getTimestamp();
    //
    return new DateTime(date('Y-m-1', $time));
}
//Buscar o ultima dia do mês passado por parâmetro
function getLastDayOfMonth($date)
{
    //getTimestamp
    $time = getDateAsDateTime($date)->getTimestamp();
    //t vai buscar o ultimo dia do mês
    return new DateTime(date('Y-m-t', $time));
}

//
function getSecondsFromDateInterval($interval)
{
    //d1 necessita de ser Ummutable porque quando fizer o add do interval preciso que gere uma nova data   
    $d1 = new DateTimeImmutable;
    $d2 = $d1->add($interval);
    return $d2->getTimestamp() - $d1->getTimestamp();
}

//Função para verificar se é uma data que já passou e se essa data é uma data de trabalho ou fim de semana 
function isPastWorkday($date)
{
    //verificar se não é fim de semana e se é uma data no passado
    return !isWeekend($date) && isBefore($date, new DateTime());
}

//receber segundos e passar para horas minutos e segundos
function getTimeStringFromSeconds($seconds)
{
    //calcular horas, utilizar intdiv para obter só o valor antes da virgula 
    $h = intdiv($seconds, 3600);
    //calcular minutos (modulo ->resto da divisao dos segundos ) / 60 
    $m = intdiv($seconds % 3600, 60);
    //segundos menos (quantidade de horas menos os minutos 
    $s = $seconds - ($h * 3600) - ($m * 60);

    return sprintf('%02d:%02d:%02d', $h, $m, $s);
}

function formatDateWithLocale($date, $pattern)
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return strftime($pattern, $time);
}
