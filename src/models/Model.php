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

    //Obter os objetos da BD (passandos filtros)
    public static function get($filters = [], $columns = '*')
    {
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $columns);

        if ($result) {

            $class = get_called_class();

            while ($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }

    //OBTER UM ÚNICO REGISTO PARA IMPLEMENTAR NO LOGIN
    public static function getOne($filters = [], $columns = '*')
    {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);

        //caso result seja válido -> instânciar uma class passando o que recebi, caso contrário retornar null 
        return $result ? new $class($result->fetch_assoc()) : null;
    }

    public static function getResultSetFromSelect($filters = [], $columns = '*')
    {
        $sql = "SELECT ${columns} FROM " . static::$tableName . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);

        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    private static function getFilters($filters)
    {
        $sql = '';

        //$filters > 0 existe filtros
        if (count($filters) > 0) {
            $sql .= " WHERE 1 = 1";

            foreach ($filters as $column => $value) {
                $sql .= " AND ${column} = " . static::getFormatValue($value);
            }
        }
        return $sql;
    }

    private static function getFormatValue($value)
    {
        if (is_null($value)) {
            return "null";

            //obter o tipo da variável
        } else if (gettype($value) === 'string') {
            return "'${value}'";
        } else {
            return $value;
        }
    }
}
