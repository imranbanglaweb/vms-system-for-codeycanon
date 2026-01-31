<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Vendor;
use App\Models\Department;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get existing departments, drivers, and vendors
        $departments = Department::pluck('id')->toArray();
        $drivers = Driver::pluck('id')->toArray();
        $vendors = Vendor::pluck('id')->toArray();

        // Ensure we have data to reference
        $defaultDept = !empty($departments) ? $departments[0] : 1;
        $defaultDriver = !empty($drivers) ? $drivers[0] : null;
        $defaultVendor = !empty($vendors) ? $vendors[0] : null;

        $vehicles = [
            [
                'vehicle_number' => 'DHA-1234',
                'vehicle_name' => 'Toyota Corolla X',
                'vehicle_type_id' => 1,
                'seat_capacity' => 4,
                'ownership' => 'Owned',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-1234',
                'driver_id' => $defaultDriver,
                'vendor_id' => null,
                'alert_cell_number' => '01712345678',
                'registration_date' => '2020-01-15',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-5678',
                'vehicle_name' => 'Toyota Hiace Grand Cabin',
                'vehicle_type_id' => 2,
                'seat_capacity' => 12,
                'ownership' => 'Owned',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-5678',
                'driver_id' => count($drivers) > 1 ? $drivers[1] : $defaultDriver,
                'vendor_id' => null,
                'alert_cell_number' => '01712345679',
                'registration_date' => '2019-06-20',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-9012',
                'vehicle_name' => 'Hino Luxury Bus',
                'vehicle_type_id' => 3,
                'seat_capacity' => 40,
                'ownership' => 'Owned',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-9012',
                'driver_id' => count($drivers) > 2 ? $drivers[2] : $defaultDriver,
                'vendor_id' => null,
                'alert_cell_number' => '01712345680',
                'registration_date' => '2018-03-10',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-3456',
                'vehicle_name' => 'Mitsubishi L200 Pickup',
                'vehicle_type_id' => 4,
                'seat_capacity' => 2,
                'ownership' => 'Rented',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-3456',
                'driver_id' => null,
                'vendor_id' => $defaultVendor,
                'alert_cell_number' => '01712345681',
                'registration_date' => '2021-09-05',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-7890',
                'vehicle_name' => 'Honda City Sedan',
                'vehicle_type_id' => 1,
                'seat_capacity' => 4,
                'ownership' => 'Leased',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-7890',
                'driver_id' => count($drivers) > 3 ? $drivers[3] : $defaultDriver,
                'vendor_id' => count($vendors) > 1 ? $vendors[1] : $defaultVendor,
                'alert_cell_number' => '01712345682',
                'registration_date' => '2022-01-25',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-1111',
                'vehicle_name' => 'Ford Transit Van',
                'vehicle_type_id' => 2,
                'seat_capacity' => 15,
                'ownership' => 'Owned',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-1111',
                'driver_id' => null,
                'vendor_id' => null,
                'alert_cell_number' => '01712345683',
                'registration_date' => '2020-11-12',
                'availability_status' => 'busy',
            ],
            [
                'vehicle_number' => 'DHA-2222',
                'vehicle_name' => 'Nissan Urvan',
                'vehicle_type_id' => 2,
                'seat_capacity' => 12,
                'ownership' => 'Rented',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-2222',
                'driver_id' => null,
                'vendor_id' => count($vendors) > 2 ? $vendors[2] : $defaultVendor,
                'alert_cell_number' => '01712345684',
                'registration_date' => '2021-05-18',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-3333',
                'vehicle_name' => 'BMW 5 Series',
                'vehicle_type_id' => 1,
                'seat_capacity' => 4,
                'ownership' => 'Leased',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-3333',
                'driver_id' => count($drivers) > 4 ? $drivers[4] : $defaultDriver,
                'vendor_id' => count($vendors) > 3 ? $vendors[3] : $defaultVendor,
                'alert_cell_number' => '01712345685',
                'registration_date' => '2023-02-28',
                'availability_status' => 'available',
            ],
            [
                'vehicle_number' => 'DHA-4444',
                'vehicle_name' => 'Tata Mega Bus',
                'vehicle_type_id' => 3,
                'seat_capacity' => 50,
                'ownership' => 'Owned',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-4444',
                'driver_id' => null,
                'vendor_id' => null,
                'alert_cell_number' => '01712345686',
                'registration_date' => '2017-08-14',
                'availability_status' => 'on_leave',
            ],
            [
                'vehicle_number' => 'DHA-5555',
                'vehicle_name' => 'Toyota Prado',
                'vehicle_type_id' => 5,
                'seat_capacity' => 7,
                'ownership' => 'Owned',
                'department_id' => $defaultDept,
                'license_plate' => 'DHA-METRO-12-5555',
                'driver_id' => null,
                'vendor_id' => null,
                'alert_cell_number' => '01712345687',
                'registration_date' => '2022-07-22',
                'availability_status' => 'available',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['vehicle_number' => $vehicle['vehicle_number']],
                [
                    'vehicle_name' => $vehicle['vehicle_name'],
                    'vehicle_type_id' => $vehicle['vehicle_type_id'],
                    'seat_capacity' => $vehicle['seat_capacity'],
                    'ownership' => $vehicle['ownership'],
                    'department_id' => $vehicle['department_id'],
                    'license_plate' => $vehicle['license_plate'],
                    'driver_id' => $vehicle['driver_id'],
                    'vendor_id' => $vehicle['vendor_id'],
                    'alert_cell_number' => $vehicle['alert_cell_number'],
                    'registration_date' => $vehicle['registration_date'],
                    'availability_status' => $vehicle['availability_status'],
                    'status' => 1,
                    'created_by' => 1,
                ]
            );
        }

        // Generate 50 dummy vehicles with all fields
        for ($i = 0; $i < 50; $i++) {
            $randomDriver = $faker->randomElement(array_merge([null], $drivers));
            $randomVendor = $faker->randomElement(array_merge([null], $vendors));
            $availability = $faker->randomElement(['available', 'available', 'available', 'busy', 'on_leave']);
            
            Vehicle::create([
                'vehicle_number' => $faker->unique()->bothify('DHA-####'),
                'vehicle_name' => $faker->randomElement(['Toyota', 'Honda', 'Nissan', 'Mitsubishi', 'Ford', 'BMW', 'Mercedes', 'Hyundai']) . ' ' . $faker->randomElement(['Corolla', 'Civic', 'X-Trail', 'L200', 'Ranger', '5 Series', 'C-Class', 'Elantra']),
                'vehicle_type_id' => $faker->numberBetween(1, 8),
                'seat_capacity' => $faker->numberBetween(4, 50),
                'ownership' => $faker->randomElement(['Owned', 'Rented', 'Leased']),
                'department_id' => $faker->randomElement($departments) ?: $defaultDept,
                'license_plate' => 'DHA-METRO-' . $faker->numberBetween(10, 99) . '-' . $faker->bothify('####'),
                'driver_id' => $randomDriver,
                'vendor_id' => $randomVendor,
                'alert_cell_number' => $faker->phoneNumber,
                'registration_date' => $faker->date('Y-m-d', '2020-01-01'),
                'availability_status' => $availability,
                'status' => 1,
                'created_by' => 1,
            ]);
        }

        $this->command->info('Vehicle seeder completed with department, driver, and vendor references.');
    }
}
