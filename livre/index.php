<?php
session_start();
require_once "classes/Database.php";
require_once "classes/Guestbook.php";
require_once "classes/Reply.php";
require_once "classes/User.php";

$conn = Database::getInstance()->getConnection();
$guestbook = new Guestbook();
$reply = new Reply();
$user = new User();
var_dump($_SESSION);
$user_id = $_SESSION['user_id'];
if (isset($_GET['logout'])) {
    $user->logout();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["name"]) && !empty($_POST["message"])) {
        $user_id = $_SESSION['user_id'] ?? null;
        $guestbook->addMessage($_POST["name"], $_POST["message"], $user_id);
        header("Location: index.php");
        exit;
    }

    if (!empty($_POST["reply_name"]) && !empty($_POST["reply_message"]) && !empty($_POST["guestbook_id"])) {
        $user_id = $_SESSION['user_id'] ?? null;
        $reply->addReply($_POST["guestbook_id"], $_POST["reply_name"], $_POST["reply_message"], $user_id);
        header("Location: index.php");
        exit;
    }
}

$messages = $guestbook->getMessages();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
</head>
<body>
    <h1>Livre d'or</h1>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php if($user->isLoggedIn())
                {?>
                <li><a href="profile.php?id=<?=$user_id?>">Profil</a></li>
                <?php
                }
                else{
                    ?>
                    <li><a href="login.php">Se connecter</a></li>
                    <li><a href="register.php">S'inscrire</a></li>
                    <?php } ?>



            </ul>
        </nav>
    </header>
    <h2>Laissez un message</h2>
    <form method="POST">
    <?php if ($user->isLoggedIn()): ?>
        <input type="text" name="name" value="<?= htmlspecialchars($_SESSION['username']) ?>" readonly>
    <?php else: ?>
        <input type="text" name="name" placeholder="Votre nom" required>
    <?php endif; ?>
    <textarea name="message" placeholder="Votre message" required></textarea>
    <button type="submit">Envoyer</button>
</form>


    <h2>Messages</h2>
    <?php foreach ($messages as $msg): ?>
        <p><strong><?= htmlspecialchars($msg["name"] ?? $msg["username"]) ?></strong> (<?= $msg["created_at"] ?>) :</p>
        <p><?= nl2br(htmlspecialchars($msg["message"])) ?></p>

        <form method="POST">
            <input type="hidden" name="guestbook_id" value="<?= $msg['id'] ?>">
            <input type="text" name="reply_name" placeholder="Votre nom" required>
            <textarea name="reply_message" placeholder="Votre réponse" required></textarea>
            <button type="submit">Répondre</button>
        </form>

        <?php 
            $replies = $reply->getReplies($msg['id']);
            foreach ($replies as $rep): 
        ?>
            <div style="margin-left: 20px;">
                <p><strong><?= htmlspecialchars($rep["name"] ?? $rep["username"]) ?></strong> (<?= $rep["created_at"] ?>) :</p>
                <p><?= nl2br(htmlspecialchars($rep["message"])) ?></p>
            </div>
        <?php endforeach; ?>
        <hr>
    <?php endforeach; ?>

    
</body>
</html>
