<?php
session_start();
require_once "classes/Database.php";
require_once "classes/Reply.php";
require_once "classes/User.php";
if(!isset($_SESSION['username']))
{
    header('Location: guestbook.php');
}
$conn = Database::getInstance()->getConnection();
$reply = new Reply();
$user = new User();
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["reply_message"]) && !empty($_GET["guestbook_id"])) {
    $reply->addReply($_GET["guestbook_id"], $_POST["reply_name"], $_POST["reply_message"], $user_id);
    header("Location: guestbook.php");
    exit;
}

$guestbook_id = $_GET["guestbook_id"] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Répondre au message</title>
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
    <h1>Répondre au message</h1>
    <h2>Votre réponse au commentaire </h2>
    <form method="POST">
        <input type="hidden" name="guestbook_id" value="<?= htmlspecialchars($guestbook_id) ?>">

        <textarea name="reply_message" placeholder="Votre réponse" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
</body>

</html>