<?php

//require_once 'config.php';
class Database
{
    private $username;
    private $password;
    private $host;
    private $database;

    public function __construct()
    {
        $this->username = getenv('SHOPTHERAPY_USERNAME');
        $this->password = getenv('SHOPTHERAPY_PASSWORD');
        $this->host = getenv('SHOPTHERAPY_HOST');
        $this->database = getenv('SHOPTHERAPY_DATABASE');
    }

    public function connect(){
        try{
            $conn = new PDO(
                "pgsql:host=$this->host;port=5432;dbname=$this->database",
                $this->username,
                $this->password,
                ["sslmode"  => "prefer"]
            );

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $ex){
            die("Connection failed: ".$ex->getMessage());
        }
    }
}