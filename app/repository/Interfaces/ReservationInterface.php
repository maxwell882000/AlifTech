<?php

namespace Src\Repository\Interfaces;

use Src\Models\ReservedRoom;

interface ReservationInterface
{
    const ALL_ROOMS = "SELECT * from room";
    const CHECK_ROOM = "SELECT user.name, user.email, user.phone FROM reserved_room JOIN users 
                        ON reserved_room.phone = users.phone 
                        WHERE reserved_room.room_number = ? 
                          and reserved_room.start_date >= ? 
                          and reserved_room.end_date < ?";

    // room_id, user_id, start_date, end_date
    const RESERVE_ROOM = "INSERT INTO(reserved_room) VALUES( ?, ?, ?, ?) ";

    public function getAllRooms(): array;

    public function reserveTheRoom(ReservedRoom $reservedRoom);
}