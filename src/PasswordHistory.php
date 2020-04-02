<?php

namespace Imanghafoori\PasswordHistory;

use Illuminate\Support\Facades\Hash;
use Imanghafoori\PasswordHistory\Database\PasswordHistoryRepo;

class PasswordHistory
{
    function logForUserModel($user)
    {
        $passwordCol = $this->getPasswordCol($user);

        if ($user->$passwordCol && $user->isDirty($passwordCol)) {
            $guard = $this->getGuard($user);
            PasswordHistoryRepo::logNewPassword($user->$passwordCol, $user->getKey(), $guard);
        }
    }

    function getGuard($user)
    {
        $models = config('password_history.models');

        return $models[get_class($user)]['guard'] ?? strtolower(class_basename($user));
    }

    private function getPasswordCol($user)
    {
        $models = config('password_history.models');

        return $models[get_class($user)]['password_column'] ?? 'password';
    }

    function isInHistoryOfUser($password, $user, $depth = null)
    {
        return $this->isInHistory($password, $user->getKey(), $depth, $this->getGuard($user))->getOr(false);
    }

    function isInHistory($password, $userId, $depth = null, $guard = '')
    {
        $depth = $depth ?: config('password_history.check_depth');
        $histories = PasswordHistoryRepo::getAllPasswords($userId, $depth, $guard);

        foreach ($histories as $history) {
            if (Hash::check($password, $history->password)) {
                return nullable($history);
            }
        }

        return nullable();
    }

    function latestChangeDate($user)
    {
        $password = $this->getOfDepth($user, 1)->first();

        return nullable($password ? $password->created_at : null);
    }

    function getCurrentPassword($user)
    {
        $password = $this->getOfDepth($user, 1)->first();
        $passwordCol = $this->getPasswordCol($user);

        return nullable($password->$passwordCol ?? null);
    }

    function passwordChangesCount($user)
    {
        // When there is no password at all, we return 0 (not -1)
        $count = $this->getOfDepth($user, null)->count();

        return $count ? $count - 1 : 0;
    }

    function logPasswordForUser($passwordHash, $user)
    {
        return PasswordHistoryRepo::logNewPassword($passwordHash, $user->getKey(), $this->getGuard($user));
    }

    private function getOfDepth($user, $depth)
    {
        return PasswordHistoryRepo::fetch($user->getKey(), $depth, $this->getGuard($user), 0);
    }
}
