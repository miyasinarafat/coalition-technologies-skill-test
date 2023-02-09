<?php

namespace App\Providers;

use App\Domain\Project\ProjectRepositoryInterface;
use App\Infrastructure\Persistance\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProjectRepositoryInterface::class, ProjectRepository::class);
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
