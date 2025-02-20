<?php
include_once "session.php";
require_once "classes/Database.php";
require_once "classes/User.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
$conn = Database::getInstance()->getConnection();
$user = new User();

if (isset($_GET['logout'])) {
    $user->logout();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section class="mariage">
        <div class="mariage-content">
            <h1>Mariage de Conte Fées<br>22.07.2025</h1>
            <p>💖 Un mariage féerique AG & Leonardo Dicaprio </p>
            <a href="addMessage.php?id=<?= $user_id ?>" class="btn">Cliquez ici pour nous envoyer un message. ✨</a>
        </div>
    </section>

    <section class="discover">
        <h2 class="section-title">Découvrir ✨</h2>
        <p class="section-subtitle">✨ Une touche de magie pour un jour inoubliable ✨</p>
        <div class="discover-grid">
            <div class="discover-card">
                <div class="discover-icon">✨</div>
                <h3>Histoire d'amour </h3>
            </div>
            <div class="discover-card">
                <div class="discover-icon">🌟</div>
                <h3>Photos </h3>
            </div>
            <div class="discover-card">
                <div class="discover-icon">💫</div>
                <h3>Moments Précieux</h3>
            </div>
        </div>
    </section>
</body>

</html>