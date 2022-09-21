<?php

namespace Src\Repository;

use PDO;

class BaseRepository
{
    const HOST = "127.0.0.1:3306";
    const DB_NAME = "alif";
    const USER = "root";
    const PASSWORD = "";
    protected $currentDb;

    public function __construct()
    {
        $this->currentDb = new PDO(sprintf("mysql:host=%s;dbname=%s", static::HOST, static::DB_NAME),
            static::USER, static::PASSWORD);
    }

    protected function runQuery($query)
    {
        $this->currentDb->exec($query);
    }
}