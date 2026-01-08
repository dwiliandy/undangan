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
    $this->app->bind(
      \App\Repositories\Interfaces\RsvpRepositoryInterface::class,
      \App\Repositories\Eloquent\RsvpRepository::class
    );
    $this->app->bind(
      \App\Repositories\Interfaces\WishRepositoryInterface::class,
      \App\Repositories\Eloquent\WishRepository::class
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
