<?php

namespace App\Providers;

use App\Repositories\BookRepositoryInterface;
use App\Repositories\Eloquent\AuthorRepository;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\Eloquent\BookRepository;
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
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
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
