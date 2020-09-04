<?php

namespace Imanghafoori\PasswordHistoryTests\Integration;

use Illuminate\Support\Facades\Hash;
use Imanghafoori\PasswordHistory\Rules\NotBeInPasswordHistory;
use Imanghafoori\PasswordHistoryTests\TestCase;

class ValidationRuleTest extends TestCase
{
    /** @test */
    public function validation_passes_when_password_not_used_before()
    {
        $user = $this->createUser(['password' => Hash::make('111111')]);

        $rules = [
            'password' => [NotBeInPasswordHistory::ofUser($user)]
        ];

        $data = ['password' => '222222'];

        $validator = app('validator')->make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function validation_wont_pass_when_password_used_before()
    {
        $password = '111111';

        $user = $this->createUser(['password' => Hash::make($password)]);

        $rules = [
            'password' => [NotBeInPasswordHistory::ofUser($user)]
        ];

        $data = ['password' => $password];

        $validator = app('validator')->make($data, $rules);

        $this->assertFalse($validator->passes());
    }
}
