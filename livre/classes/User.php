<?php
require_once "Database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function register($username, $email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = :username UNION SELECT 1 FROM users WHERE email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);

            if ($stmt->fetch()) {
                return false;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

            return $stmt->execute([
                ':username' => htmlspecialchars($username),
                ':email' => htmlspecialchars($email),
                ':password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }


    
    public function updateUser($id, $username, $email)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
            return $stmt->execute([
                ':username' => htmlspecialchars($username),
                ':email' => htmlspecialchars($email),
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
    public function logout()
    {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}
