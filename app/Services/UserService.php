<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserNotLoggedInException;
use App\Models\User;
use Auth;

class UserService
{
    /**
     * @throws UserNotLoggedInException
     */
    public function getLogged(): User
    {
        $user = Auth::user();

        if ($user === null) {
            throw new UserNotLoggedInException('User is not logged in');
        }

        return $user;
    }
}
