<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'dg']);
        Role::create(['name' => 'sg']);
        Role::create(['name' => 'se']);
        Role::create(['name' => 'sc']);
        Role::create(['name' => 'enseignant']);
        Role::create(['name' => 'user']);
    }
}