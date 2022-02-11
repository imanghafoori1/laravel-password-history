<?php

namespace Imanghafoori\PasswordHistory;

use Illuminate\Support\ServiceProvider;
use Imanghafoori\PasswordHistory\Observers\UserObserver;
use Imanghafoori\PasswordHistory\Facades\PasswordHistoryManager;

class PasswordHistoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        PasswordHistoryManager::shouldProxyTo(PasswordHistory::class);
        $this->mergeConfig();
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ .'/config/password_history.php' => config_path('password_history.php')]);
            $this->setMigrationFolder();
        }

        $this->listenForModelChanges();
    }

    private function listenForModelChanges()
    {
        $userModels = array_keys(config('password_history.models'));

        foreach ($userModels as $userModel) {
            $userModel::observe(UserObserver::class);
        }
    }

    private function setMigrationFolder()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
    }

    private function mergeConfig()
    {
        $configFile = __DIR__.'/config/password_history.php';

        if($this->app->runningUnitTests()) {
            $configFile = __DIR__.'/../tests/Requirements/config/password_history.php';
        }

        $this->mergeConfigFrom($configFile, 'password_history');
    }
}
