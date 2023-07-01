<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\DebtRepository;
use App\Repositories\InvoiceRepository;
use App\Interfaces\DebtRepositoryInterface;
use App\Interfaces\DebtServiceInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Services\DebtService;
use App\Services\EmailNotificationService;
use App\Services\InvoiceService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DebtRepositoryInterface::class, DebtRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(DebtServiceInterface::class, DebtService::class);
        $this->app->bind(InvoiceServiceInterface::class, InvoiceService::class);
        $this->app->bind(NotificationServiceInterface::class, EmailNotificationService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
