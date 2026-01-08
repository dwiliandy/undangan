<?php

namespace App\Repositories\Eloquent;

use App\Models\Wish;
use App\Repositories\Interfaces\WishRepositoryInterface;

class WishRepository extends BaseRepository implements WishRepositoryInterface
{
  public function __construct(Wish $model)
  {
    parent::__construct($model);
  }
}
