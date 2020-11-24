<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * Get's an entity by it's ID.
     *
     * @param int $id
     * @return Model
     */
    public function get(int $id): ?Model;

    /**
     * Get's all entities.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Deletes an entity by it's ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Updates an entity by it's ID.
     *
     * @param int $id
     * @param array $attributes
     * @return Model
     */
    public function update(array $attributes, int $id): Model;

    public function getData(int $id = null, array $searchParams = []): Builder;

    public function getPagination();
}
