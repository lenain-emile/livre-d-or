<?php
include_once "session.php";
require_once "classes/User.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = new User();
$userData = $user->getUserById($_SESSION['user_id']);
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["username"]) && !empty($_POST["email"])) {
    if ($user->updateUser($_SESSION['user_id'], $_POST["username"], $_POST["email"])) {
        $success = "Profil mis à jour avec succès";
        $userData = $user->getUserById($_SESSION['user_id']); // Refresh user data
    } else {
        $error = "Erreur lors de la mise à jour du profil";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Livre d'or Mariage de Conte Fées</title>
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

            <h2 class="connexion-title">Mon profil</h2>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                </div>

                <button type="submit" class="btn-connect">Mettre à jour</button>
            </form>

            <div class="signup-link">
                Pas encore de compte ? <a href="Inscrivez-vous">Inscrivez-vous</a>
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