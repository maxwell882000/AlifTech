<?php

namespace Src\Commands;

use Src\Commands\Abstracts\BaseCommand;
use Src\Commands\Traits\HasCommand;
use Src\Models\User;

class UserCommand extends BaseCommand implements \Src\Commnads\Interfaces\UserInterface
{
    use HasCommand;

    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new \Src\Repository\UserRepository();
    }

    private function getRooms()
    {

    }

    private function login()
    {
        $phone = readline("Write phone : ");
        $password = readline("Write password : ");
        $user = User::login($phone, $password);
        $user_fetched = $this->userRepo->checkUser($user);
        if ($user_fetched) {
            echo "User is logged in \n";
            $this->getRooms();
        } else {
            echo "Wrong credentials \n";
        }
    }

    private function register()
    {
        $phone = readline("Write phone : ");
        $password = readline("Write password : ");
        $name = readline("Write name : ");
        $email = readline("Write email : ");
        $user = User::register($phone, $password, $name, $email);
        $response = $this->userRepo->insertUser($user);
        if ($response) {
            echo "User created \n";
        } else {
            echo "User failed to create\n";
        }
    }

    public function commandBody()
    {
        echo "==========AUTH============\n";
        echo "1. LOGIN USER\n";
        echo "2. REGISTER USER\n";
        echo "3. Back\n";
        $choice = $this->readCommand();
        switch ($choice) {
            case static::LOGIN:
                $this->login();
                break;
            case static::REGISTER:
                $this->register();
                break;
            case static::BACK:
                clearTerminal();
                $this->close();
                break;
            default:
                $this->incorrectChoice();
        }
    }
}