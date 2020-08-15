<?php

namespace Imanghafoori\PasswordHistoryTests\Feature;

use Illuminate\Support\Facades\DB;
use Imanghafoori\PasswordHistory\Database\PasswordHistory;
use Imanghafoori\PasswordHistoryTests\Requirements\Models\User;
use Imanghafoori\PasswordHistoryTests\TestCase;

class CustomFilterTest extends TestCase
{

    /** @test */
    public function testing()
    {
//        dd(DB::select('select * from sqlite_master where type="table"'));
        dd(User::count(), PasswordHistory::count());
        $query = 'young=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);

        $query = 'young=0';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }
}
