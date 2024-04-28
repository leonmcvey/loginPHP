<?php
require_once '../Models/UserDatabase.php';
require_once '../Models/Database.php';

require_once '../utils/validator.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $validator = new Validator($_POST);

    $validator->field('email')->required()->email();

    $validator->field('password')->required()->min_len(8);

    $validator->field('confirm_password')->required()->equals($_POST['password']);

    $validator->field('name')->required()->alpha_space();

    $validator->field('street_address')->required();

    $validator->field('postal_code')->required();

    $validator->field('city')->required();

    if (!$validator->is_valid()) {
        $error_messages = $validator->error_messages;
    } else {

        $database = new Database();
        $pdo = $database->getPdo();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE username = ?");
        $stmt->execute([$_POST['email']]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error_messages['email'] = 'Email already exists';
        } else {

            $userDatabase = new UserDatabase($pdo);

            $registration_result = $userDatabase->registerUser(
                $_POST['email'],
                $_POST['password'],
                $_POST['name'],
                $_POST['street_address'],
                $_POST['postal_code'],
                $_POST['city'],

            );

            if ($registration_result) {
                header("Location: /");
                exit;
            } else {
                $error_messages['general'] = 'Registration failed';
            }
        }
    }
}

include "../AccountRegister.php";
