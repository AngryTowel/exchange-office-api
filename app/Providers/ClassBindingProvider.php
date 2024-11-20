<?php

namespace App\Providers;

use App\Services\Authentication\AuthenticationService;
use App\Services\Authentication\Interfaces\AuthenticationServiceInterface;
use Illuminate\Support\ServiceProvider;

class ClassBindingProvider extends ServiceProvider
{
    public $bindings = [
        AuthenticationServiceInterface::class => AuthenticationService::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
