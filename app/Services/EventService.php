<?php

namespace App\Services;

use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class EventService
{
  protected $eventRepository;

  public function __construct(EventRepositoryInterface $eventRepository)
  {
    $this->eventRepository = $eventRepository;
  }

  public function getEventBySlug(string $slug): ?Model
  {
    return $this->eventRepository->getWithDetails($slug);
  }
}
