<?php

namespace App\Providers;

use App\Repositories\ImdbRepository;
use App\Repositories\CachingRepository;
use App\Interfaces\MoviesRepositoryInterface;
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
        $this->app->bind(MoviesRepositoryInterface::class, function ($app) {
            return new CachingRepository(
                new ImdbRepository
            );
        });
    }

    public function provides()
    {
        return [
            MoviesRepositoryInterface::class,
        ];
    }

}
