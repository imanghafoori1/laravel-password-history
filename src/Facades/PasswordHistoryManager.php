<?php

namespace Imanghafoori\PasswordHistory\Facades;

use Imanghafoori\SmartFacades\Facade;

/**
 * Class PasswordHistoryManager
 *
 * @package \Imanghafoori\PasswordHistory\Facades
 *
 * @method static isInHistoryOfUser($password, $user, $depth = null)
 * @method static isInHistory($password, $userId, $depth = null, $guard = '')
 * @method static logPasswordForUser($password, $user)
 * @method static passwordChangesCount($user)
 * @method static getCurrentPassword($user)
 * @method static latestChangeDate($user)
 * @method static logForUserModel($user)
 *
 * @see \Imanghafoori\PasswordHistory\PasswordHistory
 */
class PasswordHistoryManager extends Facade
{
    //
}
