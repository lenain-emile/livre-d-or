<?php
include_once "session.php";
require_once "classes/Database.php";
require_once "classes/User.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = new User();
$user_info = $user->getUserById($_SESSION['user_id']);
if ($user_info['user_permissions'] != 2) {
    header("Location: index.php");
    exit;
}

$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Liste des utilisateurs</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Liste des utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                     
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['user_firstname']) ?></td>
                        <td><?= htmlspecialchars($user['user_lastname']) ?></td>
                        <td>
                            <a href="profile.php?id=<?= $user['id'] ?>">Modifier</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>