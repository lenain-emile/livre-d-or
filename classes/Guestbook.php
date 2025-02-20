<?php
require_once "Database.php";

class Guestbook {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function addMessage($name, $message, $user_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO guestbook (name, message, user_id) VALUES (:name, :message, :user_id)");
        return $stmt->execute([
            ':name' => htmlspecialchars($name),
            ':message' => htmlspecialchars($message),
            ':user_id' => $user_id
        ]);
    }

    public function getMessages() {
        $stmt = $this->conn->query("SELECT g.*, u.username, u.user_firstname AS firstname, u.user_lastname AS lastname FROM guestbook g LEFT JOIN users u ON g.user_id = u.id ORDER BY g.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM guestbook WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMessagesByMessageContent($searchTerm) {
        $sql = "SELECT g.*, u.username FROM guestbook g LEFT JOIN users u ON g.user_id = u.id WHERE g.message LIKE :searchTerm ORDER BY g.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':searchTerm' => '%' . $searchTerm . '%']); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateMessage($id, $name, $message) {
        $stmt = $this->conn->prepare("UPDATE guestbook SET name = :name, message = :message WHERE id = :id");
        return $stmt->execute([
            ':name' => htmlspecialchars($name),
            ':message' => htmlspecialchars($message),
            ':id' => $id
        ]);
    }
    public function deleteMessage($id) {
        $stmt = $this->conn->prepare("DELETE FROM guestbook WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
