<?php

use Delight\Auth\Auth;

class UserDatabase
{
  private $auth;
  private $pdo;

  public function __construct($pdo)
  {
    $this->auth = new Auth($pdo);

    $this->pdo = $pdo;
  }

  public function registerUser($email, $password, $name, $street_address, $postal_code, $city)
  {
    try {
      $userId = $this->auth->register($email, $password, $name);

      if ($userId !== null) {
        $stmt = $this->pdo->prepare("INSERT INTO customers (username, street_address, postal_code, city) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$email, $street_address, $postal_code, $city]);

        if (!$result) {
          error_log("Error inserting data into customers table: " . implode(", ", $stmt->errorInfo()));
          return false;
        } else {
          error_log("Error inserting data into customers table: " . implode(", ", $stmt->errorInfo()));
          return false;
        }
      } else {
        return false;
      }
    } catch (\Delight\Auth\InvalidEmailException $e) {
      return false;
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      return false;
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
      return false;
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      return false;
    } catch (\PDOException $e) {
      error_log("PDO Exception: " . $e->getMessage());
      return false;
    } catch (\Exception $e) {
      error_log("Exception: " . $e->getMessage());
      return false;
    }
  }

  public function loginUser($email, $password)
  {
    try {
      $this->auth->login($email, $password);

      $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        return $user['id'];
      } else {
        return false;
      }
    } catch (\Delight\Auth\InvalidEmailException $e) {
      return false;
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      return false;
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
      return false;
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      return false;
    } catch (\PDOException $e) {
      error_log("PDO Exception: " . $e->getMessage());
      return false;
    } catch (\Exception $e) {
      error_log("Exception: " . $e->getMessage());
      return false;
    }
  }

  public function checkEmail($email)
  {
    try {
      $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $count = $stmt->fetchColumn();

      return $count > 0;
    } catch (PDOException $e) {
      error_log("PDO Exception: " . $e->getMessage());
      return false;
    } catch (Exception $e) {
      error_log("Exception: " . $e->getMessage());
      return false;
    }
  }
  public function getUserIdByEmail($email)
  {
    try {
      $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      return $user['id'] ?? null; // Return user ID or null if not found
    } catch (PDOException $e) {
      error_log("PDO Exception: " . $e->getMessage());
      return null;
    } catch (Exception $e) {
      error_log("Exception: " . $e->getMessage());
      return null;
    }
  }

  public function isResetTokenValid($resetToken)
  {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM users_resets WHERE token = :token AND expires > :current_time");
      $current_time = time();
      $stmt->bindParam(":token", $resetToken);
      $stmt->bindParam(":current_time", $current_time, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch();

      if ($result) {
        return true;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      error_log("Error checking reset token validity: " . $e->getMessage());
      return false;
    }
  }

  public function getUserIdByResetToken($resetToken)
  {
    try {
      $stmt = $this->pdo->prepare("SELECT user FROM users_resets WHERE token = ?");

      $stmt->execute([$resetToken]);

      $userId = $stmt->fetchColumn();

      $stmt->closeCursor();

      return $userId;
    } catch (PDOException $e) {
      error_log("Error getting user ID by reset token: " . $e->getMessage());
      return false;
    }
  }

  public function resetPassword($userId, $newPassword)
  {
    try {
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

      $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");

      $stmt->bindParam(1, $hashedPassword);
      $stmt->bindParam(2, $userId);

      $stmt->execute();

      $stmt->closeCursor();

      return true;
    } catch (PDOException $e) {
      error_log("Error resetting password: " . $e->getMessage());
      return false;
    }
  }
}

