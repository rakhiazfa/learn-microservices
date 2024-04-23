<?php

namespace Database\Seeders;

use App\Models\Identity;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Identity::create([
            'registration_number' => '5056060506070001',
            'name' => 'Rakhi Azfa Rifansya',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '2004-07-06',
            'gender' => 'Pria',
            'email' => 'rakhi.azfa@merdekalio.co.id',
            'password' => 'password',
            'is_active' => true,
        ]);
    }
}
