<?php
// Include necessary files.
include_once "session.php";
require_once "classes/Database.php";
require_once "classes/Guestbook.php";
require_once "classes/Reply.php";
require_once "classes/User.php";

// Get database connection instance.
$conn = Database::getInstance()->getConnection();
// Create instances of the classes.
$guestbook = new Guestbook();
$reply = new Reply();
$user = new User();

if ($_POST) {
    if (!empty($_POST["message"])) {
        // Get the user ID from the session, or null if not logged in.
        $user_id = $_SESSION['user_id'] ?? null;

        // Add the message to the guestbook.
        $guestbook->addMessage($_POST["name"], $_POST["message"], $user_id);

        // Redirect to the guestbook page.
        header("Location: guestbook.php");
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

        <div class="content-box">
            <h3 class="page-title">Laissez un message féerique</h3>
    
            <form method="POST">
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Titre du message</label>
                        <input type="text" name="name" id="name">
                    </div>

                    <div class="form-group">
                        <label for="message">Votre message enchanteur</label>
                        <textarea id="message" name="message" placeholder="Partagez vos vœux magiques pour les mariés..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Envoyer vos vœux</button>
                </form>
        </div>


</body>

</html>