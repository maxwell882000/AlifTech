<?php

namespace Src\Commands;

use Src\Commands\Abstracts\BaseCommand;
use Src\Commands\Interfaces\RoomCommand;
use Src\Inputs\ReservedRoomInput;
use Src\Repository\Exceptions\ReserveException;
use Src\Repository\ReservationRepository;

class ListRooms extends BaseCommand implements RoomCommand
{
    use \Src\Commands\Traits\HasCommand;

    private $reserveRepo;
    private $reserveInput;

    public function __construct($user)
    {
        $this->reserveRepo = new ReservationRepository();
        $this->reserveInput = new ReservedRoomInput($user);
    }


    public function checkReservation()
    {
        try {
            $room = $this->reserveInput->getRoom();
            $this->reserveRepo->reserveTheRoom($room);
            echo "Successfully reserved the room !\n";
            mail($room->getUser()->getEmail(),
                "Successful reservation",
                sprintf("You have successfully reserved %s room. Start date is %s",
                    $room->getRoom(),
                    $room->getStartDate()));
        } catch (ReserveException $ex) {
            $reservedRoom = $ex->getReservedRoom();
            echo sprintf("Room is already reserved by %s \n", $reservedRoom->getUser()->getName());
            echo sprintf("Start date : %s \n", $reservedRoom->getStartDate());
            echo sprintf("End date: %s \n", $reservedRoom->getEndDate());
        }

    }

    public function commandBody()
    {
        echo "==========Rooms============\n";
        echo "1. RESERVE ROOM\n";
        echo "2. BACK\n";
        $choice = $this->readCommand();
        switch ($choice) {
            case static::RESERVE_ROOM:
                $this->checkReservation();
                break;
            case static::BACK:
                $this->close();
                break;
            default:
                $this->incorrectChoice();
        }
    }
}