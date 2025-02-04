<?php

require_once __DIR__ . '/../helpers/Conn.class.php';

class Dao
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn->getConn();
    }

    protected function executeQuery($sql, $types, $params)
    {
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        
        return $data;
    }
}