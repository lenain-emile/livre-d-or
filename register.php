<?php
include_once "session.php";
require_once "classes/User.php";

$user = new User();

if ($_POST && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    if ($user->register($_POST["username"], $_POST["email"], $_POST['firstname'], $_POST['lastname'], $_POST["password"])) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Erreur lors de l'inscription";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Livre d'or Mariage de Conte Fées</title>
    <link rel="stylesheet" href="style/login.css">
 
</head>
<body>
    <div class="page-container">
        <div class="page-header">
            <h1>Livre d'or</h1>
            <h2>Mariage de Conte Fées</h2>
            <h3>22.07.2025</h3>
        </div>

        <div class="connexion-container">
            <ul class="nav-list">
                <li><a href="index.php">Accueil</a></li>
                
            </ul>
            
            <h2 class="connexion-title">Inscription</h2>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>   
            <form method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                </div>

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" placeholder="Prénom" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom de famille</label>
                    <input type="text" name="lastname" placeholder="Nom de famille" required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="btn-connect">S'inscrire</button>
            </form>
            
            <div class="signup-link">
                Déjà un compte ? <a href="login.php">Connectez-vous</a>
            </div>
            
            <div class="heart-icon">♥</div>
            <div class="couple-names">Un mariage féerique AG & Leonardo Dicaprio</div>
        </div>
        
        <div class="magic-sparkle sparkle1">✧</div>
        <div class="magic-sparkle sparkle2">✦</div>
        <div class="magic-sparkle sparkle3">✧</div>
        <div class="magic-sparkle sparkle4">✦</div>
    </div>
</body>
</html>
