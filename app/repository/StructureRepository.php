<?php

namespace Src\Repository;


use Src\Repository\Interfaces\QueryInterface;

class StructureRepository extends BaseRepository implements QueryInterface
{
    private function createAllTables()
    {
        $this->runQuery(static::CREATE_ROOM);
        $this->runQuery(static::CREATE_USER);
        $this->runQuery(static::CREATE_RESERVE_ROOM);
    }

    private function populateRoom()
    {
        $this->runQuery(static::INSERT_ROOMS);
    }

    public function createStructure()
    {
        $this->createAllTables();
        $this->populateRoom();
    }
}