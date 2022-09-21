<?php


use Src\Commands\Abstracts\BaseCommand;
use Src\Commands\Repository\Exception\ReserveException;
use Src\Models\ReserveDate;
use Src\Models\ReservedRoom;
use Src\Models\Room;
use Src\Repository\ReservationRepository;

class ListRoom extends BaseCommand implements \Src\Commnads\Interfaces\RoomCommand
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
        $start_date = $this->correctStartDate();
        $end_date = $this->correctDuration($start_date);
        return [$start_date, $end_date];
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
        } catch (ReserveException $ex) {

        }

    }

    public function commandBody()
    {
        echo "==========Rooms============";
        echo "1. RESERVE ROOM";
        echo "2. BACK";
        $choice = $this->readCommand();
        switch ($choice) {
            case static::RESERVE_ROOM:
                $this->reserveRoom();
        }
    }
}