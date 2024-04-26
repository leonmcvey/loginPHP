<?php
require_once '../Models/UserDatabase.php';
require_once '../Models/Database.php';
require_once '../utils/validator.php';

$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator($_POST);
    $validator->field('password')->required()->min_len(8);
    $validator->field('confirm_password')->required()->equals($_POST['password']);

    if (!$validator->is_valid()) {
        $error_messages = $validator->error_messages;
    } else {

        $resetToken = isset($_GET['token']) ? $_GET['token'] : null;
        $newPassword = $_POST['password'];

        if (!$resetToken) {
            $error_messages['general'] = 'Token parameter is missing in the URL.';
        } else {
            $database = new Database();
            $pdo = $database->getPdo();
            $userDatabase = new UserDatabase($pdo);

            if ($userDatabase->isResetTokenValid($resetToken)) {
                $userId = $userDatabase->getUserIdByResetToken($resetToken);
                $success = $userDatabase->resetPassword($userId, $newPassword);

                if ($success) {

                    header("Location: /");
                    exit;
                } else {
                    $error_messages['general'] = 'Failed to reset password. Please try again.';
                }
            } else {
                $error_messages['general'] = 'Invalid or expired token. Please try again.';
            }
        }
    }
}


include 'reset_password_form.php';


