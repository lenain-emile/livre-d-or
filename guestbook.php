<?php
include_once "session.php";
require_once "classes/Database.php";
require_once "classes/Guestbook.php";
require_once "classes/User.php";

$conn = Database::getInstance()->getConnection();
$guestbook = new Guestbook();
$user = new User();

if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
    $user_info = $user->getUserById($user_id);
    $user_permissions = $user_info['user_permissions'];
} else {
    $user_permissions = 0; // Default to non-admin if not logged in
}

$messages = $guestbook->getMessages();
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
} else {
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
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="header">
            <div class="decorative-line">
                <span>✧</span>
                <span>❋</span>
                <span>✧</span>
            </div>
            <h1>Mariage de Conte Fées</h1>
            <div class="date">22.7.2025</div>
            <div class="decorative-line">
                <span>✧</span>
                <span>❋</span>
                <span>✧</span>
            </div>
        </div>
        <div class="search-container">
            <form method="GET" action="guestbook.php">
                <input type="text" name="search" placeholder="Rechercher un message..." value="<?= @htmlspecialchars($searchTerm) ?>">
                <button class="btn-search" type="submit">Rechercher</button>
            </form>
        </div>
        <div class="container-link">
            <a class="btn" href="addMessage.php?id=<?= $user_id ?>">Laissez un message féerique</a>
        </div>

        <div class="messages">
            <h3 class="page-title">Messages des invités</h3>

            <?php foreach ($messages as $msg) { ?>
                <div class="message">
                    <div class="message-header">
                        <p>De la part de <?= htmlspecialchars($msg["firstname"]) ?> <?= htmlspecialchars($msg["lastname"]) ?><span class="message-date"><?= $msg["created_at"] ?></span></p>
                        <p><?=htmlspecialchars($msg['name'])?></p>
                    </div>
                    <p><?= nl2br(htmlspecialchars($msg["message"])) ?></p>
                    <?php if ($user_permissions == 2 || $msg['user_id'] == $user_id){ ?>
                        <div class="admin-options">
                            <a href="updateMessage.php?id=<?= $msg['id'] ?>">Modifier</a>
                            <a href="deleteMessage.php?id=<?= $msg['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">Supprimer</a>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>