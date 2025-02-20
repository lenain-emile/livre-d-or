<?php
require_once "Database.php";

class Reply {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function addReply($guestbook_id, $name, $message, $user_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO replies (guestbook_id, name, message, user_id) VALUES (:guestbook_id, :name, :message, :user_id)");
        return $stmt->execute([
            ':guestbook_id' => $guestbook_id,
            ':name' => htmlspecialchars($name),
            ':message' => htmlspecialchars($message),
            ':user_id' => $user_id
        ]);
    }

    public function getReplies($guestbook_id) {
        $stmt = $this->conn->prepare("SELECT r.*, u.username FROM replies r LEFT JOIN users u ON r.user_id = u.id WHERE r.guestbook_id = :guestbook_id ORDER BY r.created_at ASC");
        $stmt->execute([':guestbook_id' => $guestbook_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
