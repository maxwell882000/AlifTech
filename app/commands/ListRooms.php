<?php

namespace Src\Commands;

use Src\Commands\Abstracts\BaseCommand;
use Src\Commands\Interfaces\RoomCommand;
use Src\Models\ReserveDate;
use Src\Models\ReservedRoom;
use Src\Models\Room;
use Src\Repository\Exceptions\ReserveException;
use Src\Repository\ReservationRepository;

class ListRooms extends BaseCommand implements RoomCommand
{
    use \Src\Commands\Traits\HasCommand;

    private $user;
    private $reserveRepo;

    public function __construct($user)
    {
        $this->user = $user;
        $this->reserveRepo = new ReservationRepository();
    }

    private function correctRoomNumber(): string
    {
        while (true) {
            $room_number = $this->readCommand("Write a room number from 1 to 5: ");
            if ($room_number >= 1 && $room_number <= 5) {
                return $room_number;
            } else {
                echo "Wrong room number ! \n";
            }
        }
    }

    private function correctDuration(ReserveDate $date)
    {
        while (true) {
            $duration = $this->readCommand("Write duration in hours (less 24) : ");
            if ($duration < 24) {
                return $date->getEndDate($duration);
            }
            echo "Wrong duration !\n";
        }
    }

    private function correctStartDate()
    {
        $year = $this->readCommand("Write a year: ");
        $month = $this->readCommand("Write a month: ");
        $day = $this->readCommand("Write a day: ");
        $hours = $this->readCommand("Write an hour: ");
        return new ReserveDate($year, $month, $day, $hours);
    }

    private function correctDates(): array
    {
        echo "Write start date of reservation \n";
        $startDate = $this->correctStartDate();
        $endDate = $this->correctDuration($startDate);
        return [$startDate, $endDate];
    }

    private function getRoom(): ReservedRoom
    {
        $room = Room::new($this->correctRoomNumber());
        $dates = $this->correctDates();
        return ReservedRoom::new($room, $this->user, $dates[0], $dates[1]);
    }

    public function checkReservation()
    {
        try {
            $room = $this->getRoom();
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