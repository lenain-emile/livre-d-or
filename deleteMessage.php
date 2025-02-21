<?php
include_once "session.php";
require_once "classes/Database.php";
require_once "classes/Guestbook.php";
require_once "classes/User.php";

$conn = Database::getInstance()->getConnection();
$guestbook = new Guestbook();
$user = new User();
// Check if the user is logged in
if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
    $user_info = $user->getUserById($user_id);
    $user_permissions = $user_info['user_permissions'];
} else {
    header("Location: login.php");
    exit;
}
if(isset($_GET['id']))
{
    $message_id = $_GET['id'];
    $message = $guestbook->getMessageById($message_id);
}
// Check if the user is an admin (2) or is the author
if ($user_permissions != 2 && $message['user_id'] != $user_id) {
    header("Location: guestbook.php");
    exit;
}

if ($message_id) {
    $guestbook->deleteMessage($message_id);
}

header("Location: guestbook.php");
exit;
?>