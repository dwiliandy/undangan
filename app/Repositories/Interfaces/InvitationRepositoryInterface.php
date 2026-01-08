<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface InvitationRepositoryInterface extends BaseRepositoryInterface
{
  public function getBySlug(string $slug): ?Model;
  public function getByEventAndSlug(int $eventId, string $slug): ?Model;
}
