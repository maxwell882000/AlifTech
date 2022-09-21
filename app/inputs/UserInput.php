<?php

namespace Src\Inputs;

use Src\Models\User;

class UserInput
{

    // validation can be done here
    public function login(): User
    {
        $phone = readline("Write phone : ");
        $password = readline("Write password : ");
        return User::login($phone, $password);
    }

    public function register(): User
    {
        $phone = readline("Write phone : ");
        $password = readline("Write password : ");
        $name = readline("Write name : ");
        $email = readline("Write email : ");
        return User::register($phone, $password, $name, $email);
    }
}