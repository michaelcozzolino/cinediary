<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    protected Model $model;

    protected string $modelTable;

    public function __construct(protected string $modelClass)
    {
        $this->model = app($modelClass);
        $this->modelTable = $this->model->getTable();
    }

    public function find($id): Model
    {
        return $this->model::find($id);
    }

    /**
     * @param  array<string, string>  $attributes
     *
     * @return Model
     */
    public function create(array $attributes = []): Model
    {
        return $this->model::create($attributes);
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    protected function scopeFindByCriteria(array $criteria): Builder
    {
       return $this->model::where($criteria);
    }

    public function findAllByCriteria(array $criteria, array $columns = ['*']): Collection
    {
        return $this->scopeFindByCriteria($criteria)->get($columns);
    }

    public function findFirstByCriteria(array $criteria, array $columns = ['*']): ?Model
    {
        return $this->scopeFindByCriteria($criteria)->first($columns);
    }

//    public function updateByCriteria(array $criteria)
//    {
//        $this->model::where('')
//    }
}
