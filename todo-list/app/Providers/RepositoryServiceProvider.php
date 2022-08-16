<?php

namespace App\Providers;

use App\Repository\Interfaces\TaskPriorityRepositoryInterface;
use App\Repository\Interfaces\TaskRepositoryInterface;
use App\Repository\Interfaces\TaskStatusRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\TaskPriorityRepository;
use App\Repository\TaskRepository;
use App\Repository\TaskStatusRepository;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskPriorityRepositoryInterface::class, TaskPriorityRepository::class);
        $this->app->bind(TaskStatusRepositoryInterface::class, TaskStatusRepository::class);
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
