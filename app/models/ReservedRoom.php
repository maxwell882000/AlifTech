<?php

namespace Src\Models;
class ReservedRoom
{
    private Room $room;
    private User $user;
    private ReserveDate $start_date;
    private ReserveDate $end_date;

    public function __construct($data)
    {
        $this->room = $data['room'] ?? null;
        $this->user = $data['user'] ?? null;
        $this->start_date = $data['start_date'] ?? null;
        $this->end_date = $data['end_date'] ?? null;
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
        return $this->start_date->getDate();
    }

    public function getEndDate(): string
    {
        return $this->end_date->getDate();
    }
}