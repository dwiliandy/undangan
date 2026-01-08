<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements BaseRepositoryInterface
{
  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  public function all(): Collection
  {
    return $this->model->all();
  }

  public function find(int $id): ?Model
  {
    return $this->model->find($id);
  }

  public function create(array $data): Model
  {
    return $this->model->create($data);
  }

  public function update(int $id, array $data): bool
  {
    return $this->model->find($id)->update($data);
  }

  public function delete(int $id): bool
  {
    return $this->model->destroy($id);
  }
}
