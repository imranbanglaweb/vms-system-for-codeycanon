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
            LocationSeeder::class,
            UnitSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            EmployeeSeeder::class,
            DepartmentHeadSeeder::class,
            VehicleTypeSeeder::class,
            LicenseTypeSeeder::class,
            VendorSeeder::class,
            DriverSeeder::class,
            VehicleSeeder::class,
            RequisitionSeeder::class,
            RequisitionPassengerSeeder::class,
            TripSheetSeeder::class,
            MaintenanceTypeSeeder::class,
            MaintenanceCategorySeeder::class,
            MaintenanceVendorSeeder::class,
            MaintenanceRequisitionSeeder::class,
            LanguageSeeder::class,
            SubscriptionPlanSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}
