<?php

namespace Src\Models;

class Room
{
    private $room_number;

    public function __construct($data)
    {
        $this->room_number = $data['room_number'];
    }
    public static function new($data) {
        return new static(['room_number' => $data]);
    }
    public function getRoomNumber() {
        return $this->room_number;
    }
}