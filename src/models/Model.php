<?php

class Model
{

    //
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];


    //construtor que recebe um array
    function __construct($arr)
    {
        $this->loadFromArray($arr);
    }

    //passar os valores para dentro de value caso o array esteja definido
    public function loadFromArray($arr)
    {
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    //get para termos acesso a todas as "keys" da tabela
    public function __get($key)
    {
        return $this->values[$key];
    }

    //receber chave e valor para guardar dentro do array "values"
    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }
}
