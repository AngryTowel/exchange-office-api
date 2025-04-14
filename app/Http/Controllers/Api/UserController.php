<?php

namespace App\Http\Controllers\Api;

use App\DTO\User\EditUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected UserServiceInterface $userService) {}
    public function index(): JsonResponse
    {
        return $this->respond(new UserResource($this->userService->getUser()));
    }
    public function update(EditUserRequest $request): JsonResponse
    {
        return $this->respond(new UserResource($this->userService->updateUser(EditUserDTO::fromArray($request->validated()))));
    }
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        return $this->respond($this->userService->updatePassword($request->get('password')));
    }
    public function getOrganizations(): JsonResponse
    {
        return $this->respond($this->userService->getOrganizations());
    }
}
