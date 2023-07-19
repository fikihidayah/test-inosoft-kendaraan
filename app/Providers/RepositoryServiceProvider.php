<?php

namespace App\Providers;

use App\Interface\Kendaraan\MobilInterface;
use App\Interface\Kendaraan\MotorInterface;
use App\Interface\SaleInterface;
use App\Interface\UserInterface;
use App\Repository\Kendaraan\MobilRepository;
use App\Repository\Kendaraan\MotorRepository;
use App\Repository\SaleRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register user interface as repository in laravel Service Container
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(MotorInterface::class, MotorRepository::class);
        $this->app->bind(MobilInterface::class, MobilRepository::class);
        $this->app->bind(SaleInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
