<?php
require_once '../Models/UserDatabase.php';
require_once '../Models/Database.php';
require_once "../registration/requestReset.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    $database = new Database();
    $pdo = $database->getPdo();
    $userDatabase = new UserDatabase($pdo);

    $user_id = $userDatabase->getUserIdByEmail($email);

    $token = generateResetToken();

    $selector = generateUniqueSelector();

    $expires = time() + (24 * 60 * 60);

    if (storeResetToken($pdo, $user_id, $selector, $token, $expires)) {
        sendPasswordResetEmail($email, $token);
    }
}

header("Location: reset_password_confirmation.php");
exit;
?>