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
</head>
<body>
    <h1>Livre d'or</h1>

    <h2>Laissez un message</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Titre du commentaire</label>
            <input type="text" name="name" id="name">
        </div>
        <textarea name="message" placeholder="Votre message" required></textarea>
        <button type="submit">Envoyer</button>
    </form>

</body>
</html>