<?php
include_once "session.php";
require_once "classes/User.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = new User();
$logged_in_user_id = $_SESSION['user_id'];
$userData = $user->getUserById($logged_in_user_id);
$user_id = $_GET['id'] ?? $logged_in_user_id;

if ($user_id != $logged_in_user_id && $userData['user_permissions'] != 2) {
    header("Location: index.php");
    exit;
}


$profileData = $user->getUserById($user_id);

if ($_POST && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"])) {
    $user_permissions = $profileData['user_permissions'];
    if ($userData['user_permissions'] == 2 && isset($_POST["user_permissions"])) {
        $user_permissions = $_POST["user_permissions"];
    }
    if ($user->updateUser($user_id, $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["lastname"], $user_permissions)) {
        $success = "Profil mis à jour avec succès";
        $profileData = $user->getUserById($user_id); // Refresh user data
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
    <title>Profil - Livre d'or Mariage de Conte Fées</title>
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
            <?php if (isset($success)) echo "<p>$success</p>"; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($profileData['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($profileData['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" placeholder="Prénom" value="<?php echo htmlspecialchars($profileData['user_firstname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Nom de famille</label>
                    <input type="text" name="lastname" placeholder="Nom" value="<?php echo htmlspecialchars($profileData['user_lastname']); ?>" required>
                </div>
                <?php if ($userData['user_permissions'] == 2) { ?>
                    <div class="form-group">
                        <label for="user_permissions">Permissions</label>
                        <select name="user_permissions" id="user_permissions">
                            <option value="0" <?= $profileData['user_permissions'] == 0 ? 'selected' : '' ?>>Compte désactivé</option>
                            <option value="1" <?= $profileData['user_permissions'] == 1 ? 'selected' : '' ?>>Utilisateur</option>
                            <option value="2" <?= $profileData['user_permissions'] == 2 ? 'selected' : '' ?>>Administrateur</option>
                        </select>
                    </div>
                <?php } ?>
                <button type="submit" class="btn-connect">Mettre à jour</button>
            </form>

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