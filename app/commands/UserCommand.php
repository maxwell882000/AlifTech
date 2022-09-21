<?php

namespace Src\Commands;

use Src\Commands\Abstracts\BaseCommand;
use Src\Commands\Interfaces\UserInterface;
use Src\Commands\Traits\HasCommand;
use Src\Models\User;

class UserCommand extends BaseCommand implements UserInterface
{
    use HasCommand;

    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new \Src\Repository\UserRepository();
    }

    private function getRooms($user)
    {
        sleep(2);
        clearTerminal();
        $listRooms = new ListRooms($user);
        $listRooms->getCommand();
    }

    private function login()
    {
        $phone = readline("Write phone : ");
        $password = readline("Write password : ");
        $user = User::login($phone, $password);
        $userFetched = $this->userRepo->checkUser($user);
        if ($userFetched) {
            echo "User is logged in \n";
            $this->getRooms($userFetched);
        } else {
            clearTerminal();
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
            $this->getRooms($user);
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