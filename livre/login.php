<?php
include_once "session.php";
require_once "classes/User.php";

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["email"]) && !empty($_POST["password"])) {
    if ($user->login($_POST["email"], $_POST["password"])) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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

    
    <h1>Connexion</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
</body>
</html>
