<?php

namespace Imanghafoori\PasswordHistory\Database;

class PasswordHistoryRepo
{
    public static function getPreviousPasswords($userId, $depth = null, $guard = '')
    {
        return self::fetch($userId, $depth, $guard, 1);
    }

    public static function getAllPasswords($userId, $depth = null, $guard = '')
    {
        return self::fetch($userId, $depth, $guard);
    }

    public static function fetch($userId, $depth = null, $guard = '', $offset = null)
    {
        $q = PasswordHistory::query()->where('user_id', $userId);

        if ($guard) {
            $q->where('guard', $guard);
        }

        if (! is_null($offset)) {
            $q->offset($offset);
        }

        if (! is_null($depth)) {
            $q->take($depth);
        }

        return $q->latest('id')->get();
    }

    public static function getCurrentPassword($id, $guard)
    {
        return self::fetch($id, 1, $guard, 0)->first();
    }

    public static function logNewPassword($password, $user_id, $guard = '')
    {
        return PasswordHistory::query()->create(get_defined_vars());
    }
}
