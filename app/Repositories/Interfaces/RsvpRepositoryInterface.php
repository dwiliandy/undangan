<?php

namespace App\Repositories\Interfaces;

interface RsvpRepositoryInterface extends BaseRepositoryInterface
{
  public function updateOrCreate(array $attributes, array $values);
}
