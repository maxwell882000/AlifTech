<?php

namespace Src\Repository;

use Src\Models\ReservedRoom;
use Src\Models\Room;
use Src\Models\User;
use Src\Repository\Interfaces\ReservationInterface;

class  ReservationRepository extends BaseRepository implements ReservationInterface
{


    public function getAllRooms(): array
    {
        $stmt = $this->currentDb->query(static::ALL_ROOMS);
        $response = [];
        $data = $stmt->fetchAll();
        foreach ($data as $row) {
            $response[] = new Room($row);
        }
        return $response;
    }

    // get the user
    private function checkFree(ReservedRoom $reservedRoom): User
    {
        $stmt = $this->currentDb->prepare(static::CHECK_ROOM);
        $stmt->execute([$reservedRoom->getRoom(), $reservedRoom->getStartDate(), $reservedRoom->getEndDate()]);
        $data = $stmt->fetch();
        return new User($data);
    }

    public function reserveTheRoom(ReservedRoom $reservedRoom)
    {
        $this->checkFree($reservedRoom);
        $stmt = $this->currentDb->prepare(static::RESERVE_ROOM);
        $stmt->execute([
            $reservedRoom->getRoom(),
            $reservedRoom->getUser()->getPhone(),
            $reservedRoom->getStartDate(),
            $reservedRoom->getEndDate()
        ]);
        return $stmt->fetch();
    }
}