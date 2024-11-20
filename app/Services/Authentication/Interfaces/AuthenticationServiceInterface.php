<?php

namespace App\Services\Authentication\Interfaces;

use App\DTO\Auth\CredentialsDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\DTO\Auth\TokenDTO;
use App\Models\User;

interface AuthenticationServiceInterface
{
    /**
     *  Accepts email and password as inputs and grants an access token to the user.
     *  Or returns an error and message if credentials are not valid.
     * @param CredentialsDTO $credentials
     *
     * @return TokenDTO
     */
    public function credentialsLogin(CredentialsDTO $credentials): TokenDTO;
    /**
     * Get the logged-in user and invalidate the token used for the request.
     */
    public function logout(): bool;
    /**
     * Accepts a user as a parameter grants a token to the user and returns an object back with access token including
     * the user as well.
     * @param User $user
     * @return TokenDTO
     */
    function generateToken(User $user): TokenDTO;
    /**
     *  Accepts email as input and sends a reset mail to the user. If email doesn't exist in the DB
     *  return an error with a message.
     */
    public function resetPassword(string $email);
    /**
     *  Accepts email, password and token as inputs and updates the password of the user.
     *  Or returns an error and message if credentials are not valid.
     *  The return payload should be declared and documented in the interface of the function.
     * @param ResetPasswordDTO $data
     *
     */
    public function updatePassword(ResetPasswordDTO $data);
    /**
     * Returns the authenticated user.
     */
    public function getAuthenticatedUser(): User;
}
