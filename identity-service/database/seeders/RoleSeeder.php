<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Ketua RW']);
        Role::create(['name' => 'Sekretaris']);
        Role::create(['name' => 'Bendahara']);
        Role::create(['name' => 'Keamanan']);
        Role::create(['name' => 'Ketua DKM']);
        Role::create(['name' => 'Ketua RT']);
    }
}
