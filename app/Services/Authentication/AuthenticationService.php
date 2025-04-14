<?php

namespace App\Services\Authentication;

use App\DTO\Auth\CredentialsDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\DTO\Auth\TokenDTO;
use App\Mail\Auth\ResetPassword;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Authentication\Interfaces\AuthenticationServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct(protected UserRepository $userRepository) {}

    public function credentialsLogin(CredentialsDTO $credentials): TokenDTO
    {
        if (Auth::attempt(['email' => $credentials->email, 'password' => $credentials->password])) {
            $user = $this->userRepository->getAuthenticatedUser();

            return $this->generateToken($user);
        } else {
            abort(403, 'error.auth.invalid_credentials');
        }
    }

    public function logout(): bool
    {
        $user = $this->userRepository->getAuthenticatedUser();

        return $user->currentAccessToken()->delete();
    }

    function generateToken(User $user): TokenDTO
    {
        $token = $user->createToken('api_access');

        return TokenDTO::fromArray([
            'token' => $token->plainTextToken,
            'user' => $user
        ]);
    }

    public function resetPassword(string $email): bool
    {
        $user = $this->userRepository->findBy('email', $email)->first();
        $token = Password::createToken($user);

        Mail::to($user->email)->send(new ResetPassword($token));
        return true;
    }

    public function updatePassword(ResetPasswordDTO $data): bool
    {
        $token = $this->userRepository->getResetToken($data->token);
        if (!isset($token)) abort(401, 'errors.auth.invalid_token');

        $user = $this->userRepository->findBy('email', $token->email)->first();
        $this->userRepository->updatePassword($user, $data->password);

        return true;
    }
}
