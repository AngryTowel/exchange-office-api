<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()->create([
            'first_name' => 'Emel',
            'last_name' => 'Islamoski',
            'email' => 'emelislamoski2@gmail.com',
            'password' => 'Emel123!',
        ]);
        $user2 = User::factory()->create([
            'first_name' => 'Emir',
            'last_name' => 'Useinoski',
            'email' => 'emir.useinoski@gmail.com',
            'password' => 'Emir123!',
        ]);

        $this->call([
            OrganizationSeeder::class,
        ]);

        $user->organizations()->attach([1, 2]);

        $user2->organizations()->attach([3]);
    }
}
