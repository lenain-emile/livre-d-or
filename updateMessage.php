<?php
include_once "session.php";
require_once "classes/Database.php";
require_once "classes/Guestbook.php";
require_once "classes/Reply.php";
require_once "classes/User.php";

$conn = Database::getInstance()->getConnection();
$guestbook = new Guestbook();
$reply = new Reply();
$user = new User();

// Check if the user is logged in.
if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
    $user_info = $user->getUserById($user_id);
    $user_permissions = $user_info['user_permissions'];
} else {
    header("Location: login.php");
    exit;
}

$message_id = $_GET['id'] ?? null;

$message = $guestbook->getMessageById($message_id);

if ($user_permissions != 2 && $message['user_id'] != $user_id) {
    header("Location: guestbook.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST["name"]) && !empty($_POST["message"])) {
        $guestbook->updateMessage($message_id, $_POST["name"], $_POST["message"]);
        header("Location: guestbook.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le message - Livre d'or</title>
    <link rel="stylesheet" href="style/commentaire.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="header">
            <div class="decorative-line">
                <span>✧</span>
                <span>❋</span>
                <span>✧</span>
            </div>
            <h1>Modifier le message</h1>
            <h2>Mariage de Conte Fées</h2>
            <div class="date">22.7.2025</div>
            <div class="decorative-line">
                <span>✧</span>
                <span>❋</span>
                <span>✧</span>
            </div>
        </div>

        <div class="content-box">
            <h3 class="page-title">Modifier votre message</h3>
    
            <form method="POST">
                <div class="form-group">
                    <label for="name">Titre du message</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($message['name']) ?>">
                </div>

                <div class="form-group">
                    <label for="message">Votre message enchanteur</label>
                    <textarea id="message" name="message" placeholder="Partagez vos vœux magiques pour les mariés..."><?= htmlspecialchars($message['message']) ?></textarea>
                </div>

                <button type="submit" class="submit-btn">Mettre à jour votre message</button>
            </form>
        </div>
    </div>
</body>

</html>