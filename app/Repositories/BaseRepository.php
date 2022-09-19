<?php

declare(strict_types=1);

namespace App\Repositories;

//use Bosnadev\Repositories\Exceptions\RepositoryException;
use App\Contracts\RepositoryInterface;
use App\Exceptions\Repositories\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @param  App    $app
     * @param  Model  $model
     *
     * @throws RepositoryException
     */
    public function __construct(protected App $app, protected Model $model)
    {
        $this->makeModel();
    }

    abstract protected function model(): string;

    /**
     * @throws
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if ($model instanceof Model === false) {
            throw new RepositoryException(
                sprintf('Class %s must be an instance of %s', $this->model(), Model::class)
            );
        }

        return $this->model = $model;
    }

    public function all($columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate($perPage = 15, $columns = ['*'])
    {
        // TODO: Implement paginate() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id, $columns = ['*'])
    {
        // TODO: Implement find() method.
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        // TODO: Implement findBy() method.
    }
}
