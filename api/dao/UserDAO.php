<?php

class UserDAO
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function create(User $user)
    {
        $username = $user->getUsername();
        $password = $user->getPassword();

        $stmt = $this->conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $user->setId($stmt->insert_id);
        $stmt->close();
    }

    public function getUserByUsernameAndPassword(string $username, string $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = false;

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $user = new User($row['id'], $row['username'], $row['password']);
        }

        $stmt->close();
        
        return $user;
    }

    public function getUserByUsername(string $username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = null;

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $user = new User($row['id'], $row['username'], $row['password']);
        }

        $stmt->close();

        return $user;
    }

    public function userExistsByUsername(string $username)
    {
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();

        return $result->num_rows > 0;
    }
}