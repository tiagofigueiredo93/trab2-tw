<?php

class Database
{
    public static function getConnection()
    {
        //caminho para a pasta onde tenho as informações da base de dados. /../ sair da pasta config para ter acesso ao ficheiro "env.ini"
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');

        //parse_ini_file para analisar um arquivo de configuração ini e retorna as configurações
        $env = parse_ini_file($envPath);

        $conn = new mysqli($env['host'], $env['username'], $env['password'], $env['database']);

        if ($conn->connect_error) {
            die("Erro: " . $conn->connect_error);
        }

        return $conn;
    }

    public static function getResultFromQuery($sql)
    {
        //self para poder utilizar a função getConnection
        $conn = self::getConnection();
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    public static function executeSQL($sql)
    {
        $conn = self::getConnection();
        //verificar se existe uma conexão
        if (!mysqli_query($conn, $sql)) {
            throw new Exception(mysqli_error($conn));
        }

        $id = $conn->insert_id;
        $conn->close();
        return $id;
    }
}
