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

    public function register($username, $email, $first_name, $last_name, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM users WHERE username = :username UNION SELECT 1 FROM users WHERE email = :email");
            $stmt->execute([':username' => $username, ':email' => $email]);

            if ($stmt->fetch()) {
                return false;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO users (username, email, user_firstname, user_lastname, password) VALUES (:username, :email, :user_firstname, :user_lastname, :password)");
            $stmt->execute([
                ':username' => htmlspecialchars($username),
                ':email' => htmlspecialchars($email),
                ':user_firstname' => htmlspecialchars($first_name),
                ':user_lastname' => htmlspecialchars($last_name),
                ':password' => $hashedPassword
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur :  " . $e->getMessage();
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
            $_SESSION['user_permissions'] = $user['user_permissions'];
            return true;
        }
        return false;
    }

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT id, username, email, user_firstname, user_lastname FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $username, $email, $firstname, $lastname, $user_permissions) {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET username = :username, email = :email, user_firstname = :firstname, user_lastname = :lastname, user_permissions = :user_permissions WHERE id = :id");
            return $stmt->execute([
                ':username' => htmlspecialchars($username),
                ':email' => htmlspecialchars($email),
                ':firstname' => htmlspecialchars($firstname),
                ':lastname' => htmlspecialchars($lastname),
                ':user_permissions' => $user_permissions,
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
