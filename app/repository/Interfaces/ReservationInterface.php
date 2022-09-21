<?php

namespace Src\Repository\Interfaces;

use Src\Models\ReservedRoom;

interface ReservationInterface
{
    const ALL_ROOMS = "SELECT * from room";
    const CHECK_ROOM = "SELECT * FROM reserve_room INNER JOIN user 
                        ON reserve_room.phone = user.phone";
//                        WHERE reserve_room.room_number = ?
//                          and reserve_room.start_date > ?
//                          and reserve_room.end_date < ?";

    // room_id, user_id, start_date, end_date
    const RESERVE_ROOM = "INSERT INTO reserve_room VALUES( ?, ?, ?, ?) ";

    public function getAllRooms(): array;

    public function reserveTheRoom(ReservedRoom $reservedRoom);
}