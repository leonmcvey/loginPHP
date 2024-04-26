<?php

require_once '../Models/UserDatabase.php';

class Auth
{
    private $userDatabase;

    public function __construct(UserDatabase $userDatabase)
    {
        $this->userDatabase = $userDatabase;
    }

    public function loginUser($email, $password)
    {
        return $this->userDatabase->loginUser($email, $password);
    }

}
