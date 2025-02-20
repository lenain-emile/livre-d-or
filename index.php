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
    <title>Accueil</title>
</head>

<body>
    <h1>Accueil</h1>

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

</body>

</html>