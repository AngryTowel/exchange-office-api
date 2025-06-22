<?php

namespace App\Providers;

use App\Services\Authentication\AuthenticationService;
use App\Services\Authentication\Interfaces\AuthenticationServiceInterface;
use App\Services\Forms\FormsService;
use App\Services\Forms\Interfaces\FormsServiceInterface;
use App\Services\Http\HttpService;
use App\Services\Http\Interfaces\HttpServiceInterface;
use App\Services\Organization\CurrencyService;
use App\Services\Organization\Interfaces\CurrencyServiceInterface;
use App\Services\Organization\Interfaces\OrganizationServiceInterface;
use App\Services\Organization\OrganizationService;
use App\Services\PDF\Interfaces\PDFServiceInterface;
use App\Services\PDF\PDFService;
use App\Services\User\Interfaces\UserServiceInterface;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class ClassBindingProvider extends ServiceProvider
{
    public $bindings = [
        AuthenticationServiceInterface::class => AuthenticationService::class,
        UserServiceInterface::class => UserService::class,
        HttpServiceInterface::class => HttpService::class,
        OrganizationServiceInterface::class => OrganizationService::class,
        CurrencyServiceInterface::class => CurrencyService::class,
        FormsServiceInterface::class => FormsService::class,
        PDFServiceInterface::class => PDFService::class,
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
