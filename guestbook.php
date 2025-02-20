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
    header("Location: guestbook2.php");
    exit;
}
if($_SESSION['user_id'])
{
    $user_id = $_SESSION['user_id'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or - Mariage de Conte Fées</title>
    <link rel="stylesheet" href="style/commentaire.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="decorative-line">
                <span>✧</span>
                <span>❋</span>
                <span>✧</span>
            </div>
            <h1>Livre d'or</h1>
            <h2>Mariage de Conte Fées</h2>
            <div class="date">22.7.2025</div>
            <div class="decorative-line">
                <span>✧</span>
                <span>❋</span>
                <span>✧</span>
            </div>
        </div>
        
        <div class="content-box message">
            <h3 class="page-title">Laissez un message féerique</h3>
            
            <a href="addMessage.php?id=<?= $user_id ?>">Écrire un message</a>
        </div>
        
        <div class="messages">
            <h3 class="page-title">Messages des invités</h3>
            
            <?php foreach ($messages as $msg) { ?>
                <div class="message">
                    <div class="message-header">
                        <p>De <?= htmlspecialchars($msg["firstname"]) ?> <?= htmlspecialchars($msg["lastname"]) ?><span class="message-date"><?= $msg["created_at"] ?></span></p>
                    </div>
                    <p><?= nl2br(htmlspecialchars($msg["message"])) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>