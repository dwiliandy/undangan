<?php

namespace App\Repositories\Eloquent;

use App\Models\Invitation;
use App\Repositories\Interfaces\InvitationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class InvitationRepository extends BaseRepository implements InvitationRepositoryInterface
{
  public function __construct(Invitation $model)
  {
    parent::__construct($model);
  }

  public function getBySlug(string $slug): ?Model
  {
    return $this->model->where('slug', $slug)->first();
  }

  public function getByEventAndSlug(int $eventId, string $slug): ?Model
  {
    return $this->model->where('event_id', $eventId)->where('slug', $slug)->first();
  }
}
