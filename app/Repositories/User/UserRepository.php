<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public $model = User::class;

    /**
     * Accepts a User model and a password as a parameter and saves it in the database
     * @param User $user
     * @param $password
     * @return void
     */
    public function updatePassword(User $user, $password): void
    {
        $user->forceFill([
            'password' => $password
        ]);
        $user->save();
    }

    public function getResetToken(string $token)
    {
        // Each password token is valid and lives for 15 minutes in the database
        $date = Carbon::now()->subMinutes(15);
        return DB::table('password_reset_tokens')
            ->whereDate('created_at', '>=', $date)
            ->get()->filter(function ($item) use ($token) {
                return Hash::check($token, $item->token);
            })->first();
    }

    public function getUserById($id): User
    {
        return $this->model::with(['organisation', 'theme'])->findOrFail($id);
    }

    public function listOrganisationUsers($organisation_id)
    {
        return $this->model::where('organisation_id', $organisation_id)->get();
    }
}
