<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    $this->app->bind(
      \App\Repositories\Interfaces\BaseRepositoryInterface::class,
      \App\Repositories\Eloquent\BaseRepository::class
    );
    $this->app->bind(
      \App\Repositories\Interfaces\EventRepositoryInterface::class,
      \App\Repositories\Eloquent\EventRepository::class
    );
    $this->app->bind(
      \App\Repositories\Interfaces\InvitationRepositoryInterface::class,
      \App\Repositories\Eloquent\InvitationRepository::class
    );
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}
