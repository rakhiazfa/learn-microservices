<?php

namespace Database\Seeders;

use App\Models\AccessRight;
use Illuminate\Database\Seeder;

class AccessRightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccessRight::factory()->count(10)->create();
    }
}
