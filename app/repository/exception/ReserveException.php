<?php

namespace Src\Commands\Repository\Exception;

use Src\Models\ReservedRoom;
use Throwable;

class ReserveException extends \Exception
{
    private ReservedRoom $reservedRoom;

    public function __construct(ReservedRoom $reservedRoom, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->reservedRoom = $reservedRoom;
        parent::__construct($message, $code, $previous);
    }
    public function getReservedRoom() {
        return $this->reservedRoom;
    }
}