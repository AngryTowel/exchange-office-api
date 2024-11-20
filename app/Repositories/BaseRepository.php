<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    /**
     * Model::class
     *
     */
    public $model;

    /**
     * @var array
     */
    public array $filters = [];

    public function findAll(): Collection
    {
        return $this->model::all();
    }

    public function findBy(string $column, $value, $condition = null): mixed
    {
        if ($condition == null)
            return $this->model::where($column, $value);
        else
            return $this->model::where($column, $condition, $value);
    }

    public function findByMany(string $column, array $values): mixed
    {
        return $this->model::whereIn($column, $values);
    }

    public function create(array $data): mixed
    {
        return $this->model::create($data)->fresh();
    }

    public function updateOrCreate(array $condition, array $data): mixed
    {
        return $this->model::updateOrCreate($condition, $data)->fresh();
    }

    public function firstOrCreate(array $condition, array $data = null): mixed
    {
        $c = $data != null ? $data : $condition;
        return $this->model::firstOrCreate($condition, $c)->fresh();
    }

    public function insert(array $data): mixed
    {
        return $this->model::insert($data);
    }

    /**
     * @param  $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data): mixed
    {
        $item = $this->findById($id);
        $item->fill($data);
        $item->save();

        return $item->fresh();
    }

    /**
     * @param  $id
     *
     * @return mixed
     */
    public function findById($id): mixed
    {
        return $this->model::find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        return $this->model::destroy($id);
    }

    /**
     * @param int $paginate
     * @param array $relations
     * @return mixed
     */
    public function getPaginated(int $paginate = 10, array $relations = []): mixed
    {
        return $this->model::with($relations)
            ->paginate($paginate);
    }

    public function upsert(array $data, array $value, array $attributes)
    {
        return $this->model::upsert($data, $value, $attributes);
    }

//    public function filterByValue(string $term, $relations = [], int $limit = 5, $includeRelations = true): mixed {
//        return $this->model::singleValueFilter($term, $includeRelations)->with($relations)->limit($limit)->latest();
//    }
}
