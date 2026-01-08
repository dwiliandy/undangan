<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
  public function __construct(Event $model)
  {
    parent::__construct($model);
  }

  public function getBySlug(string $slug): ?Model
  {
    return $this->model->where('slug', $slug)->first();
  }

  public function getWithDetails(string $slug): ?Model
  {
    return $this->model->with([
      'template',
      'weddingEvent',
      'eventJourneys',
      'eventLocations',
      'eventGalleries',
      'eventBanks'
    ])->where('slug', $slug)->where('is_active', true)->first();
  }

  public function getActiveEvents()
  {
    return $this->model->where('is_active', true)->get();
  }
}
