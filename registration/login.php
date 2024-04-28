<?php
require_once '../Models/UserDatabase.php';
require_once "../Models/Database.php";
require_once "storesession.php";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $database = new Database();
    $pdo = $database->getPdo();

    $userDatabase = new UserDatabase($pdo);


    if (!empty($email) && !empty($password)) {
        $login_result = $userDatabase->loginUser($email, $password);

        if ($login_result !== false) {
            $_SESSION["email"] = $email;

            $user_id = $login_result;

            storeSession($pdo, $user_id);

            header("Location: /");
            exit;
        } else {
            $message = 'Email or password invalid';
        }
    } else {
        $message = 'Email and password are required';
    }
}

header("Location: /AccountLogin.php?error=" . urlencode($message));
exit;
?>