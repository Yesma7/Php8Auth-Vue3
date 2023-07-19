<?php

class Database
{   
    private $host = "127.0.0.1";
    private $dbname = "loginphp";
    private $username = "root";
    private $password = "";

    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ups! Hay un problema " . $exception->getMessage();
        }

        return $this->conn;
    }
}
