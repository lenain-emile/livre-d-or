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

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["message"])) {
    $guestbook->addMessage($_POST["name"], $_POST["message"], $user_id);
    header("Location: guestbook.php");
    exit;
}

$messages = $guestbook->getMessages();
if(isset($_GET['search']))
{
    $searchTerm = $_GET['search'];
}

else
{
    $searchTerm = null;
}

if ($searchTerm) {
    $messages = $guestbook->getMessagesByMessageContent($searchTerm);
} else {
    $messages = $guestbook->getMessages();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <?php if ($user->isLoggedIn()) { ?>
                    <li><a href="profile.php?id=<?= $user_id ?>">Profil</a></li>
                    <li><a href="guestbook.php">Livre d'or</a></li>

                <?php
                } else {
                ?>
                    <li><a href="login.php">Se connecter</a></li>
                    <li><a href="register.php">S'inscrire</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>
    <h1>Livre d'or</h1>
    <h2>Rechercher un message</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Rechercher un message">
        <button type="submit">Rechercher</button>
    </form>


    <h2>Messages</h2>
    <?php foreach ($messages as $msg) { ?>
        <h3><?= htmlspecialchars($msg["name"] ?? $msg["username"]) ?> (<?= $msg["created_at"] ?>) :</h3>
        <p><?= nl2br(htmlspecialchars($msg["message"])) ?></p>
        <a href="reply.php?guestbook_id=<?= $msg['id'] ?>">Répondre</a>

        <?php
        $replies = $reply->getReplies($msg['id']);
        foreach ($replies as $reply) {
        ?>
            <div style="margin-left: 20px;">
                <p><strong><?= htmlspecialchars($reply["username"]) ?></strong> (<?= $reply["created_at"] ?>) :</p>
                <p><?= nl2br(htmlspecialchars($reply["message"])) ?></p>
            </div>
        <?php } ?>
        <hr>
    <?php } ?>
</body>

</html>