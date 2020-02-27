<?php

namespace Imanghafoori\PasswordHistory\Observers;

use Imanghafoori\PasswordHistory\Facades\PasswordHistoryManager;

class UserObserver
{
    function saved($user)
    {
        PasswordHistoryManager::logForUserModel($user);
    }
}
