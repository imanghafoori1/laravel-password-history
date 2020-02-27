<?php

namespace Imanghafoori\PasswordHistory\Rules;

use Imanghafoori\Models\Auth\User;
use Illuminate\Contracts\Validation\Rule;
use Imanghafoori\PasswordHistory\Facades\PasswordHistoryManager;

class UnusedPassword implements Rule
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $depth = config('password_history.check_depth');

        return ! PasswordHistoryManager::isInHistoryOfUser($value, $this->user, $depth);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('auth.password_used');
    }
}
