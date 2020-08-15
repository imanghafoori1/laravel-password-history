<?php

namespace Imanghafoori\PasswordHistoryTests;

use Imanghafoori\PasswordHistory\PasswordHistoryServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return PasswordHistoryServiceProvider::class;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/../src/Database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/Requirements/database/migrations');
    }
}