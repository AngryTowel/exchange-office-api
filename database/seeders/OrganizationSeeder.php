<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::factory()->create([
            'name' => 'ER-Solutions',
            'exchange_id' => '001232',
            'owner_id' => 1,
            'address' => 'Struga, Labunista bb, 6336'
        ]);
        Organization::factory()->create([
            'name' => 'Menuvacnica Struga',
            'exchange_id' => '1100232',
            'owner_id' => 1,
            'address' => 'Struga, Boris Kidric 6330'
        ]);
        Organization::factory()->create([
            'name' => 'Erda',
            'exchange_id' => '33241233112',
            'owner_id' => 2,
            'address' => 'Struga, Boris Kidric 6330'
        ]);
    }
}
