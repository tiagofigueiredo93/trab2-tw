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

    //Retornar todos valores dentro do array $values
    public function getValues()
    {
        return $this->values;
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

    //recebe os filtros e a lista de colunas
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

    //INSERÇÃO NA BASE DE DADOS ------- IMPLODE pega num array e transforma numa string
    public function insert()
    {
        $sql = "INSERT INTO " . static::$tableName . " ("
            . implode(",", static::$columns) . ") VALUES (";
        foreach (static::$columns as $col) {
            //visto que a função vai ser usada através de uma instancia é necessário usar o $this e depois do valor colocar uma virgula
            $sql .= static::getFormatValue($this->$col) . ",";
        }
        //para retirar a ultima virgula e fechar os parênteses
        $sql[strlen($sql) - 1] = ')';
        //receber id atual
        $id = Database::executeSQL($sql);
        //definir id
        $this->id = $id;
    }

    public function update()
    {
        $sql = "UPDATE " . static::$tableName . " SET ";

        foreach (static::$columns as $col) {
            $sql .= " ${col} = " . static::getFormatValue($this->$col) . ",";
        }
        //para retirar a ultima virgula e deixar um espaço em branco
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSQL($sql);
    }


    //Fazer uma contagem consoante a coluna ou os filtros necessários
    public static function getCount($filters = [])
    {
        $result = static::getResultSetFromSelect($filters, 'count(*) as count');

        return $result->fetch_assoc()['count'];
    }

    //metodo de instancia delete
    public function delete()
    {
        static::deleteById($this->id);
    }


    //APAGAR
    public static function deleteById($id)
    {
        $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    //Responsável por montar a cláusula WHERE
    private static function getFilters($filters)
    {
        $sql = '';

        //$filters > 0 existe filtros
        if (count($filters) > 0) {
            $sql .= " WHERE 1 = 1";

            foreach ($filters as $column => $value) {
                //Caso seja necessário utilizar um sql puro "cru"
                if ($column == 'raw') {
                    $sql .= " AND {$value}";
                } else {
                    $sql .= " AND ${column} = " . static::getFormatValue($value);
                }
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
