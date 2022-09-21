<?php

namespace Src\Commands;

use Src\Commands\Abstracts\BaseCommand;
use Src\Commands\Traits\HasCommand;
use Src\Commnads\Interfaces\MainInterface;
use Src\Repository\StructureRepository;

class MainCommand extends BaseCommand implements MainInterface
{
    use HasCommand;

    private function setDB()
    {
        $structure = new StructureRepository();
        $structure->createStructure();
    }

    private function getRooms()
    {
        $userCommand = new UserCommand();
        $userCommand->getCommand();
    }

    public function commandBody()
    {

        echo "========Welcome==========\n";
        echo "1. SET DB DATA\n";
        echo "2. GET LIST OF ROOM\n";
        echo "3. EXIT\n";
        $get_command = $this->readCommand();
        switch ($get_command) {
            case static::SET_DB:
                $this->setDB();
                clearTerminal();
                break;
            case static::GET_ROOMS:
                $this->getRooms();
                clearTerminal();
                break;
            case static::EXISTS:
                $this->close();
                break;
            default:
                $this->incorrectChoice();
        }
    }

}