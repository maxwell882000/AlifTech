<?php

namespace Src\Commands\Abstracts;

use Src\Commnads\Interfaces\CommandInterface;

abstract class BaseCommand implements CommandInterface
{
    private bool $finishChoice = true;
    private bool $returnCommand = true;

    final public function getCommand(): bool
    {
        while ($this->finishChoice) {
            $this->commandBody();
        }
        return $this->returnCommand;
    }

    protected function close()
    {
        $this->finishChoice = false;
    }

    protected function switchReturnValue()
    {
        $this->returnCommand = true;
    }

    abstract function commandBody();
}