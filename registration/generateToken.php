<?php

require_once '../Models/UserDatabase.php';
require_once '../Models/Database.php';

use Ramsey\Uuid\Uuid;

function generateResetToken()
{
    return Uuid::uuid4()->toString();
}

function generateUniqueSelector()
{
    return Uuid::uuid4()->toString();
}
function storeResetToken($pdo, $user_id, $selector, $token, $expires)
{
    try {
        $stmt = $pdo->prepare("INSERT INTO users_resets (user, selector, token, expires) VALUES (:user_id, :selector, :token, :expires)");

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":selector", $selector);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":expires", $expires);

        $success = $stmt->execute();

        if (!$success) {
            $errorInfo = $stmt->errorInfo();
            echo "Error executing query: " . $errorInfo[2];
            return false;
        }

        $stmt->closeCursor();

        return true;
    } catch (PDOException $e) {
        echo "Error inserting reset token: " . $e->getMessage();
        return false;
    }
}


