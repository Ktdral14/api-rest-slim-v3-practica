<?php

class Database
{
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = 'AngelEdyCG1999';
    private $dbName = 'api-rest';

    // Connection
    public function dbConnection()
    {
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $dbConnection = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
