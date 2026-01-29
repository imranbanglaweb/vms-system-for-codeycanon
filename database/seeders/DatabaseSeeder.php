<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            LocationSeeder::class,
            UnitSeeder::class,
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            VehicleTypeSeeder::class,
            VendorSeeder::class,
            DriverSeeder::class,
            VehicleSeeder::class,
            RequisitionSeeder::class,
            RequisitionPassengerSeeder::class,
            LanguageSeeder::class,
            SubscriptionPlanSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}
