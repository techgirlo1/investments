<?php

namespace App\Providers;
use App\Repositories\InvestmentRepository;
use App\Interfaces\InvestmentRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
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
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );


        $this->app->bind(
            InvestmentRepositoryInterface::class,
            InvestmentRepository::class
        );
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
