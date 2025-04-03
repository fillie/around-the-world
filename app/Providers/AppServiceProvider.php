<?php

namespace App\Providers;

use App\Clients\OpenAiClient;
use App\Repositories\Contracts\AdviceRepositoryInterface;
use App\Repositories\Contracts\VisitRepositoryInterface;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use App\Repositories\Eloquent\EloquentAdviceRepository;
use App\Repositories\Eloquent\EloquentVisitRepository;
use App\Repositories\Eloquent\EloquentWishlistRepository;
use Illuminate\Http\Client\Factory as HttpClient;
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
        $this->app->bind(
            AdviceRepositoryInterface::class,
            EloquentAdviceRepository::class
        );
        $this->app->bind(
            WishlistRepositoryInterface::class,
            EloquentWishlistRepository::class
        );

        $this->app->bind(OpenAiClient::class, function () {
            return new OpenAiClient(
                app(HttpClient::class),
                config('services.openai.url'),
                config('services.openai.key'),
                config('services.openai.model'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
