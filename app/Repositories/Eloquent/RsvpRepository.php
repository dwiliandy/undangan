<?php

namespace App\Repositories\Eloquent;

use App\Models\Rsvp;
use App\Repositories\Interfaces\RsvpRepositoryInterface;

class RsvpRepository extends BaseRepository implements RsvpRepositoryInterface
{
  public function __construct(Rsvp $model)
  {
    parent::__construct($model);
  }

  public function updateOrCreate(array $attributes, array $values)
  {
    return $this->model->updateOrCreate($attributes, $values);
  }
}
