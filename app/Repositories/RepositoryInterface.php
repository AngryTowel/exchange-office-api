<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all the entities within the DB
     * @return mixed
     */
    public function findAll();

    /**
     * Get the entry in the DB with the provided id
     * @param  int  $id
     */
    public function findById(int $id);

    /**
     * Provide a column and value to compare by and return entities accordingly
     * @param  string  $column
     * @param $value
     */
    public function findBy(string $column, $value);

    /**
     * Provide data for the model to be created. The function will return the created model after.
     * @param  array  $data
     */
    public function create(array $data);

    /**
     * Update the data of the model with the provided id and return the updated model.
     * @param  int  $id
     * @param  array  $data
     */
    public function update(int $id, array $data);

    /**
     * Delete the model with the provided id.
     * @param  int  $id
     */
    public function delete(int $id);
}
