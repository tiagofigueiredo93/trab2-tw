<?php

class WorkingHours extends Model
{
    protected static $tableName = 'working_hours';
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];

    public static function loadFormUserAndDate($userId, $workDate)
    {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        //caso não haja registos ele cria uma nova instância
        if (!$registry) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ]);
        }
        return $registry;
    }

    public function getNextTime()
    {
        if (!$this->time1) return 'time1';
        if (!$this->time2) return 'time2';
        if (!$this->time3) return 'time3';
        if (!$this->time4) return 'time4';
        return null;
    }

    //função responsável por marcar a presença
    public function controllerInnout($time)
    {
        //timeColumn para saber qual é a coluna que vai preencher seguidamente do $time
        $timeColumn = $this->getNextTime();
        //caso n esteja definido, todos os tempos foram executados
        if (!$timeColumn) {
            throw new AppException("Todas as presenças do dia foram efetuadas.");
        }
        $this->$timeColumn = $time;
        //para o relatorio mensal é necessário o worked_time em segundos
        $this->worked_time = getSecondsFromDateInterval($this->getWorkedInterval());
        //caso o Id esteja definido
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
    //Retornar um intevalo de tempo de horas trabalhadas
    function getWorkedInterval()
    {
        [$t1, $t2, $t3, $t4] = $this->getTimes();

        //Iniciar com a letra P de "período" e T para tempo, 0S -> 0 segundos... Inicializei em 0segundos  
        //manha
        $part1 = new DateInterval('PT0S');
        //tarde
        $part2 = new DateInterval('PT0S');

        //se t1 estiver definido, faz a diferença da hora que o utilizador marcou a presença com a hora atual 
        //manha
        if ($t1) $part1 = $t1->diff(new DateTime());
        if ($t2) $part1 = $t1->diff($t2);

        //tarde
        if ($t3) $part2 = $t3->diff(new DateTime());
        if ($t4) $part2 = $t3->diff($t4);

        return sumIntervals($part1, $part2);
    }

    //retorna o numero de horas que o funcionario efetuou na hora de almoço
    function getLunchInterval()
    {

        [, $t2, $t3,] = $this->getTimes();
        //dateInterval em 0segundos
        $lunchInterval = new DateInterval('PT0S');
        if ($t2) $lunchInterval = $t2->diff(new DateTime());
        if ($t3) $lunchInterval = $t2->diff($t3);

        return $lunchInterval;
    }

    //retornar a hora de saída
    function getExitTime()
    {
        [$t1,,, $t4] = $this->getTimes();
        $workDay = DateInterval::createFromDateString('8 hours');
        //se t1 não estiver definido retorna a hora atual
        if (!$t1) {
            return (new DateTimeImmutable())->add($workDay);
            //se t4 estiver definido retorna t4
        } else if ($t4) {
            return $t4;
            //se não pega na hora de trabalho mais a hora de almoço e soma os 2 e gera a hora de saída do funcionario
        } else {
            $total = sumIntervals($workDay, $this->getLunchInterval());
            return $t1->add($total);
        }
    }

    //Método para obter o relatório Mensal-> como não vou obter nenhum registo específico -> método static 
    public static function getMonthlyReport($userId, $date)
    {
        //Registos para obter os dados da base de dados
        $registries = [];
        //primeiro
        $startDate = getFirstDayOfMonth($date)->format('Y-m-d');
        //ultimo
        $endDate = getLastDayOfMonth($date)->format('Y-m-d');

        //obter os resultados
        $result = static::getResultSetFromSelect([
            'user_id' => $userId,
            'raw' => "work_date between '{$startDate}' AND '{$endDate}'"
        ]);
                                                      
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                //chave $row['work_date'] (dia trabalhado)
                $registries[$row['work_date']] = new WorkingHours($row);
            }
        }
        return $registries;
    }

    //
    private function getTimes()
    {
        $times = [];

        //Caso o time1,2,3,4 esteja definido, adiciona no array times a string convertida pela função "getDateFromString" se não é definido como null
        $this->time1 ? array_push($times, getDateFromString($this->time1)) : array_push($times, null);
        $this->time2 ? array_push($times, getDateFromString($this->time2)) : array_push($times, null);
        $this->time3 ? array_push($times, getDateFromString($this->time3)) : array_push($times, null);
        $this->time4 ? array_push($times, getDateFromString($this->time4)) : array_push($times, null);
        return $times;
    }
}
