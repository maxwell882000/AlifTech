<?php

namespace Src\Repository;

use Src\Models\ReservedRoom;
use Src\Models\Room;
use Src\Repository\Exceptions\ReserveException;
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
    private function checkFree(ReservedRoom $reservedRoom)
    {
        $stmt = $this->currentDb->prepare(static::CHECK_ROOM);
        $stmt->execute([$reservedRoom->getRoom(), $reservedRoom->getEndDate(), $reservedRoom->getStartDate()]);
        $data = $stmt->fetch();
        if ($data) {
            throw new ReserveException(ReservedRoom::fromDB($data));
        }
    }

    public function reserveTheRoom(ReservedRoom $reservedRoom)
    {
        $this->checkFree($reservedRoom);
        $stmt = $this->currentDb->prepare(static::RESERVE_ROOM);
        return $stmt->execute([
            $reservedRoom->getRoom(),
            $reservedRoom->getUser()->getPhone(),
            $reservedRoom->getStartDate(),
            $reservedRoom->getEndDate()
        ]);
    }
}