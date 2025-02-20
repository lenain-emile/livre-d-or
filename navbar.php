<?php
include_once "session.php";
require_once "classes/User.php";

$user = new User();
$user_id = $_SESSION['user_id'] ?? null;
?>

<header class="header">
    <nav class="nav desktop">
        <ul>
            <li>
                <div class="logo">Livre d'or</div>
            </li>
            <li><a href="index.php">Accueil</a></li>
            <?php if ($user->isLoggedIn()) { ?>
                <li><a href="profile.php?id=<?= $user_id ?>">Profil</a></li>
                <li><a href="guestbook.php">Livre d'or</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <?php if($_SESSION['user_permissions'] == 2)
                {?>
                <li><a href="admin.php">Administration</a></li>
                <?php } ?>
            <?php } else { ?>
                <li><a href="login.php">Se connecter</a></li>
                <li><a href="register.php">S'inscrire</a></li>
            <?php } ?>
        </ul>
    </nav>

    <nav class="nav mobile">
        <ul>
            <li>
                <div class="logo">Livre d'or</div>
            </li>
            <li><a href="index.php">Accueil</a></li>
            <?php if ($user->isLoggedIn()) { ?>
                <li><a href="profile.php?id=<?= $user_id ?>">Profil</a></li>
                <li><a href="guestbook.php">Livre d'or</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
                <?php if($_SESSION['user_permissions'] == 2)
                {?>
                <li><a href="admin.php">Administration</a></li>
                <?php } ?>
            <?php } else { ?>
                <li><a href="login.php">Se connecter</a></li>
                <li><a href="register.php">S'inscrire</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>