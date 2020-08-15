<?php

namespace Imanghafoori\PasswordHistoryTests\Feature;

use Imanghafoori\PasswordHistory\Database\PasswordHistory;
use Imanghafoori\PasswordHistoryTests\Requirements\Models\User;
use Imanghafoori\PasswordHistoryTests\TestCase;

class PasswordHistoryTest extends TestCase
{

    /** @test */
    public function history_is_stored_when_creating_new_user()
    {
        $this->createUser();

        $this->assertEquals(1, User::count());
        $this->assertEquals(1, PasswordHistory::count());
    }

    /** @test */
    public function history_is_being_recorded_when_changing_password()
    {
        $user = $this->createUser();

        $user->password = 'new password';

        $user->save();

        $this->assertEquals(2, PasswordHistory::count());

        $user->password = 'new password 2';

        $user->save();

        $this->assertEquals(3, PasswordHistory::count());
    }

    /** @test */
    public function history_is_not_being_recorded_when_password_is_not_changed()
    {
        $user = $this->createUser();

        $user->name = 'new name';

        $user->save();

        $this->assertEquals(1, PasswordHistory::count());

        $user->password = $user->password;

        $user->save();

        $this->assertEquals(1, PasswordHistory::count());
    }

    /** @test */
    public function history_is_not_being_recorded_when_updating_bulkly()
    {
        $user = $this->createUser();

        User::whereId($user->id)->update(['name' => 'new name']);

        $this->assertEquals(1, PasswordHistory::count());
    }

    private function createUser()
    {
        return factory(User::class)->create();
    }
}
