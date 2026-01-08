<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface EventRepositoryInterface extends BaseRepositoryInterface
{
  public function getBySlug(string $slug): ?Model;
  public function getWithDetails(string $slug): ?Model;
  public function getActiveEvents();
}
