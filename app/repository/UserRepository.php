<?php

namespace Src\Repository;

use Src\Models\User;
use Src\Repository\Interfaces\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    public function checkUser(User $user): ?User
    {
        $stmt = $this->currentDb->prepare(static::CHECK_USER);
        $stmt->execute([$user->getPhone(), $user->getPassword()]);
        if ($row = $stmt->fetch()) {
            return new User($row);
        }
        return null;
    }

    public function insertUser(User $user): bool
    {
        $stmt = $this->currentDb->prepare(static::INSERT_USER);
        return $stmt->execute([$user->getPhone(), $user->getName(), $user->getEmail(), $user->getPassword()]);
    }
}