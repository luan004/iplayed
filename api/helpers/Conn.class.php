<?php

class Conn
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'Luan!130904';
    private $db = 'ggdb';
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        
        if ($this->conn->connect_errno) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function close()
    {
        $this->conn->close();
    }
}
