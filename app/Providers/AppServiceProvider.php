<?php

namespace App\Providers;

use App\Domain\Project\ProjectRepositoryInterface;
use App\Domain\Task\TaskListRepositoryInterface;
use App\Infrastructure\Persistance\ProjectRepository;
use App\Infrastructure\Persistance\TaskListRepository;
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
        $this->app->singleton(TaskListRepositoryInterface::class, TaskListRepository::class);
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
