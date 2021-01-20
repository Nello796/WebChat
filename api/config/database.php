<?php
class Database {

    // DATABASE INFO
    private $servername = "localhost";
    private $database = "webChat";
    private $username = "debian-sys-maint";
    private $password = "IyyHcSPxLQTJinx7";

    // CONNECTION
    public $connection;

    // GET DATABASE CONNECTION
    public function getConnection() {
        try {

            $this->connection = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $this->connection;
        } catch (PDOException $e) {

            return (integer) $e->getCode();
        }
    }
}