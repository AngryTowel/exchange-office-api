<?php

namespace App\Services\User;

use App\DTO\User\EditUserDTO;
use App\Models\Currencies;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    public function __construct(protected UserRepository $userRepository) {}
    public function getUser($id = null): User
    {
        if ($id == null) {
            return $this->userRepository->getAuthenticatedUser();
        }

        return $this->userRepository->getUserById($id);
    }

    public function updateUser(EditUserDTO $data): User
    {
        $user = $this->userRepository->getAuthenticatedUser();
        $user->update($data->toArray());

        return $user;
    }

    public function updatePassword(string $password): bool
    {
        $user = $this->userRepository->getAuthenticatedUser();

        $this->userRepository->updatePassword($user, $password);

        return true;
    }

    public function getOrganizations(): Collection
    {
        // TODO: Implement getOrganizations() method.
        return $this->userRepository->getAuthenticatedUser()->organizations()->get();
    }
}
