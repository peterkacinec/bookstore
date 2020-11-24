<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

// custom actions for Author repository
class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    /**
     * AuthorRepository constructor.
     *
     * @param Author $model
     */
    public function __construct(Author $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Create an entity.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function save(array $attributes): Model
    {
        $this->model->fill($attributes);
        $this->model->save();

        return $this->model->fresh();
    }

    public function getDataForSelectbox()
    {
        return Author::get(['id', DB::raw("CONCAT(`name`,' ',`surname`) AS value")])->toArray();
    }
}
