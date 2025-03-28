<?php

namespace App\Providers;

use App\Repositories\Contracts\VisitRepositoryInterface;
use App\Repositories\Eloquent\EloquentVisitRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            VisitRepositoryInterface::class,
            EloquentVisitRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
