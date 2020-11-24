<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

// custom actions for Book repository
class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    /**
     * BookRepository constructor.
     *
     * @param Book $model
     */
    public function __construct(Book $model)
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
}
