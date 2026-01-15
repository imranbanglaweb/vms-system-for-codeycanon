<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Transport']);
        Role::firstOrCreate(['name' => 'Employee']);

    }
} 