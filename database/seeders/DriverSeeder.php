<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\Department;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get existing departments
        $departments = Department::pluck('id')->toArray();
        $defaultDept = !empty($departments) ? $departments[0] : 1;

        $drivers = [
            [
                'driver_name' => 'Mohammad Karim Ahmed',
                'license_number' => 'DL-001-2024',
                'nid' => '1234567890121',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2020-01-15',
                'date_of_birth' => '1985-06-15',
                'joining_date' => '2020-02-01',
                'present_address' => 'Mirpur, Dhaka-1216',
                'permanent_address' => 'Tangail, Bangladesh',
                'mobile' => '01711000001',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Abdul Rahim',
                'license_number' => 'DL-002-2024',
                'nid' => '1234567890122',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2019-03-20',
                'date_of_birth' => '1982-09-22',
                'joining_date' => '2019-04-01',
                'present_address' => 'Gulshan, Dhaka-1212',
                'permanent_address' => 'Rajshahi, Bangladesh',
                'mobile' => '01711000002',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Jamal Hossain',
                'license_number' => 'DL-003-2024',
                'nid' => '1234567890123',
                'license_type_id' => 2,
                'license_type' => 'Heavy Vehicle',
                'license_issue_date' => '2021-06-01',
                'date_of_birth' => '1988-03-10',
                'joining_date' => '2021-07-01',
                'present_address' => 'Banani, Dhaka-1213',
                'permanent_address' => 'Chittagong, Bangladesh',
                'mobile' => '01711000003',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Salam Khan',
                'license_number' => 'DL-004-2024',
                'nid' => '1234567890124',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2018-09-10',
                'date_of_birth' => '1980-12-05',
                'joining_date' => '2018-10-01',
                'present_address' => 'Uttara, Dhaka-1230',
                'permanent_address' => 'Khulna, Bangladesh',
                'mobile' => '01711000004',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'busy',
                'status' => 1,
            ],
            [
                'driver_name' => 'Rafiq Islam',
                'license_number' => 'DL-005-2024',
                'nid' => '1234567890125',
                'license_type_id' => 3,
                'license_type' => 'Master',
                'license_issue_date' => '2022-03-15',
                'date_of_birth' => '1990-07-18',
                'joining_date' => '2022-04-01',
                'present_address' => 'Dhanmondi, Dhaka-1205',
                'permanent_address' => 'Sylhet, Bangladesh',
                'mobile' => '01711000005',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Mostafa Ali',
                'license_number' => 'DL-006-2024',
                'nid' => '1234567890126',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2017-11-20',
                'date_of_birth' => '1978-04-25',
                'joining_date' => '2017-12-01',
                'present_address' => 'Motijheel, Dhaka-1000',
                'permanent_address' => 'Barisal, Bangladesh',
                'mobile' => '01711000006',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'on_leave',
                'status' => 1,
            ],
            [
                'driver_name' => 'Harun Or Rashid',
                'license_number' => 'DL-007-2024',
                'nid' => '1234567890127',
                'license_type_id' => 2,
                'license_type' => 'Heavy Vehicle',
                'license_issue_date' => '2019-07-01',
                'date_of_birth' => '1986-11-08',
                'joining_date' => '2019-08-01',
                'present_address' => 'Shahbagh, Dhaka-1000',
                'permanent_address' => 'Rangpur, Bangladesh',
                'mobile' => '01711000007',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Anwar Hossain',
                'license_number' => 'DL-008-2024',
                'nid' => '1234567890128',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2020-05-10',
                'date_of_birth' => '1984-01-30',
                'joining_date' => '2020-06-01',
                'present_address' => 'Badda, Dhaka-1212',
                'permanent_address' => 'Jessore, Bangladesh',
                'mobile' => '01711000008',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::updateOrCreate(
                ['license_number' => $driver['license_number']],
                [
                    'driver_name' => $driver['driver_name'],
                    'nid' => $driver['nid'],
                    'license_type_id' => $driver['license_type_id'],
                    'license_type' => $driver['license_type'],
                    'license_issue_date' => $driver['license_issue_date'],
                    'date_of_birth' => $driver['date_of_birth'],
                    'joining_date' => $driver['joining_date'],
                    'present_address' => $driver['present_address'],
                    'permanent_address' => $driver['permanent_address'],
                    'mobile' => $driver['mobile'],
                    'department_id' => $driver['department_id'],
                    'unit_id' => $driver['unit_id'],
                    'availability_status' => $driver['availability_status'],
                    'status' => $driver['status'],
                    'created_by' => 1,
                ]
            );
        }

        // Generate 50 dummy drivers with existing columns
        for ($i = 0; $i < 50; $i++) {
            $availability = $faker->randomElement(['available', 'available', 'available', 'busy', 'on_leave']);
            
            Driver::create([
                'driver_name' => $faker->name,
                'license_number' => $faker->unique()->bothify('DL-###-####'),
                'nid' => $faker->numerify('#############'),
                'license_type_id' => $faker->numberBetween(1, 3),
                'license_type' => $faker->randomElement(['Professional', 'Heavy Vehicle', 'Master']),
                'license_issue_date' => $faker->date('Y-m-d', '2022-01-01'),
                'date_of_birth' => $faker->date('Y-m-d', '1990-01-01'),
                'joining_date' => $faker->date('Y-m-d', '2023-01-01'),
                'present_address' => $faker->address,
                'permanent_address' => $faker->address,
                'mobile' => $faker->phoneNumber,
                'department_id' => $faker->randomElement($departments) ?: $defaultDept,
                'unit_id' => 1,
                'availability_status' => $availability,
                'status' => 1,
                'created_by' => 1,
            ]);
        }

        $this->command->info('Driver seeder completed with department and availability status.');
    }
}
