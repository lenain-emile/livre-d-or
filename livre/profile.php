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
    <title>Profil</title>
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

    <h1>Profil</h1>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
    <p><a href="logout.php">Déconnexion</a></p>
</body>
</html>