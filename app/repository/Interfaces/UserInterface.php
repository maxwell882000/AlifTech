<?php

namespace Src\Repository\Interfaces;

interface UserInterface
{
    const INSERT_USER = "INSERT INTO user VALUES(?, ? ,? ,?)";
    const CHECK_USER = "SELECT * FROM user WHERE user.phone = ? and user.password = ?";
}