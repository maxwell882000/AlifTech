<?php

namespace Src\Repository\Interfaces;

interface QueryInterface
{
    const CREATE_ROOM = "CREATE TABLE room (
        room_number INT NOT NULL  PRIMARY KEY
)";
    const CREATE_USER = "CREATE TABLE user (
        phone VARCHAR(12) NOT NULL PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(30) NOT NULL,
        password VARCHAR(25) NOT NULL
)";
    const CREATE_RESERVE_ROOM = "CREATE TABLE reserve_room (
        room_number  INT NOT NULL,
        phone VARCHAR (12) NOT NULL,
        start_date DATETIME NOT NULL,
        end_date DATETIME NOT NULL,
        PRIMARY KEY(phone, room_number, start_date),
        FOREIGN KEY (room_number) 
                          REFERENCES room(room_number) ON UPDATE CASCADE 
            ON DELETE RESTRICT,
        FOREIGN KEY (phone) 
                          REFERENCES user(phone)  ON UPDATE CASCADE 
            ON DELETE RESTRICT 
)";

    const INSERT_ROOMS = "INSERT INTO room VALUES (1),(2),(3),(4),(5)";

    public function createStructure();
}