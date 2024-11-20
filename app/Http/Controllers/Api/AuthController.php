<?php

namespace App\Http\Controllers\Api;

use App\DTO\Auth\CredentialsDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Services\Authentication\Interfaces\AuthenticationServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthenticationServiceInterface $authenticationService) {}
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->respond($this->authenticationService->credentialsLogin(CredentialsDTO::fromArray($request->validated())));
    }
    public function logout(): JsonResponse
    {
        return $this->respond($this->authenticationService->logout());
    }
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return $this->respond($this->authenticationService->resetPassword($request->input('email')));
    }
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        return $this->respond($this->authenticationService->updatePassword(ResetPasswordDTO::fromArray($request->validated())));
    }
}
