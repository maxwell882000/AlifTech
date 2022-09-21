<?php

namespace Src\Models;

class User
{
    private string $name;
    private string $email;
    private string $phone;
    private string $password;

    public function __construct($date)
    {
        $this->name = $date['name'] ?? "";
        $this->email = $date['email'] ?? "";
        $this->phone = $date['phone'] ?? "";
        $this->password = $date['password'] ?? "";
    }

    public static function login($phone, $password)
    {
        return new static(['phone' => $phone, 'password' => $password]);
    }

    public static function register($phone, $password, $name, $email)
    {
        return new static(['phone' => $phone, 'password' => $password, 'name' => $name, 'email' => $email]);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}