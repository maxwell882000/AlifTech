<?php

namespace Src\Commands\Traits;
trait HasCommand
{
    protected function readCommand(string $prompt = "Write a command : ")
    {
        return intval(readline($prompt));
    }

    protected function incorrectChoice() {
        echo "Incorrect choice \n";
    }

}