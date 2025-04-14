<?php

namespace App\Services\User\Interfaces;

use App\DTO\User\EditUserDTO;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /**
     * Retrieve the logged-in user or the user with the provided id.
     * @param int|null $id
     * @return User
     */
    public function getUser(int $id = null): User;

    /**
     * Receives update data for the user and updates the authenticated user.
     *
     * @param EditUserDTO $data
     * @return User
     */
    public function updateUser(EditUserDTO $data): User;

    /**
     * Accepts a string previously validated and updates the password of the user
     *
     * @param string $password
     * @return bool
     */
    public function updatePassword(string $password): bool;
    /**
     * Return the organizations that the user belongs to.
     */
    public function getOrganizations(): Collection;
}
