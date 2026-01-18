<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            DepartmentSeeder::class,
            UnitSeeder::class,
            EmployeeSeeder::class,
            VehicleTypeSeeder::class,
            VehicleSeeder::class,
            DriverSeeder::class,
            RequisitionSeeder::class,
            RequisitionPassengerSeeder::class,
            LanguageSeeder::class,
            SubscriptionPlanSeeder::class,
        ]);
    }
}
