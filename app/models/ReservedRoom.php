<?php

namespace Src\Models;
class ReservedRoom
{
    private Room $room;
    private User $user;
    private ReserveDate $startDate;
    private ReserveDate $endDate;

    public function __construct($data)
    {
        $this->room = $data['room'] ?? null;
        $this->user = $data['user'] ?? null;
        $this->startDate = $data['start_date'] ?? null;
        $this->endDate = $data['end_date'] ?? null;
    }

    public static function new(Room $room, User $user, ReserveDate $start_date, ReserveDate $end_date): ReservedRoom
    {
        return new static([
            'room' => $room,
            'user' => $user,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public static function fromDB($data): ReservedRoom
    {
        return new static([
            "room" => new Room($data),
            "user" => new User($data),
            "start_date" => ReserveDate::fromDate($data['start_date']),
            "end_date" => ReserveDate::fromDate($data['end_date'])
        ]);
    }

    public function getRoom()
    {
        return $this->room->getRoomNumber();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getStartDate(): string
    {
        return $this->startDate->getDate();
    }

    public function getEndDate(): string
    {
        return $this->endDate->getDate();
    }
}