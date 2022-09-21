<?php

namespace Src\Inputs;

use Src\Commands\Traits\HasCommand;
use Src\Models\ReserveDate;
use Src\Models\ReservedRoom;
use Src\Models\Room;
use Src\Models\User;

class ReservedRoomInput
{
    use HasCommand;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
        $startDate = $this->correctStartDate();
        $endDate = $this->correctDuration($startDate);
        return [$startDate, $endDate];
    }

    public function getRoom(): ReservedRoom
    {
        $room = Room::new($this->correctRoomNumber());
        echo "Write start date of reservation \n";
        $dates = $this->correctDates();
        return ReservedRoom::new($room, $this->user, $dates[0], $dates[1]);
    }
}