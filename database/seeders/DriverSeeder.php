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

        // Core driver data with comprehensive information
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
                'present_address' => 'Mirpur Section-12, Dhaka-1216',
                'permanent_address' => 'Tangail Sadar, Tangail',
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
                'present_address' => 'Gulshan Avenue, Dhaka-1212',
                'permanent_address' => 'Rajshahi Sadar, Rajshahi',
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
                'present_address' => 'Banani Block-D, Dhaka-1213',
                'permanent_address' => 'Chittagong Sadar, Chittagong',
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
                'present_address' => 'Uttara Sector-7, Dhaka-1230',
                'permanent_address' => 'Khulna Sadar, Khulna',
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
                'present_address' => 'Dhanmondi Road-15, Dhaka-1205',
                'permanent_address' => 'Sylhet Sadar, Sylhet',
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
                'present_address' => 'Motijheel Commercial Area, Dhaka-1000',
                'permanent_address' => 'Barisal Sadar, Barisal',
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
                'permanent_address' => 'Rangpur Sadar, Rangpur',
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
                'present_address' => 'Badda Gulshan North Road, Dhaka-1212',
                'permanent_address' => 'Jessore Sadar, Jessore',
                'mobile' => '01711000008',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Ziaur Rahman',
                'license_number' => 'DL-009-2024',
                'nid' => '1234567890129',
                'license_type_id' => 2,
                'license_type' => 'Heavy Vehicle',
                'license_issue_date' => '2021-02-14',
                'date_of_birth' => '1987-08-22',
                'joining_date' => '2021-03-01',
                'present_address' => 'Baridhara Diplomatic Zone, Dhaka-1212',
                'permanent_address' => 'Dinajpur Sadar, Dinajpur',
                'mobile' => '01711000010',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Monir Hossain',
                'license_number' => 'DL-010-2024',
                'nid' => '1234567890130',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2016-08-30',
                'date_of_birth' => '1975-03-15',
                'joining_date' => '2016-09-01',
                'present_address' => 'Lalmatia, Dhaka-1207',
                'permanent_address' => 'Mymensingh Sadar, Mymensingh',
                'mobile' => '01711000012',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'on_leave',
                'status' => 1,
            ],
            [
                'driver_name' => 'Shahidul Islam',
                'license_number' => 'DL-011-2024',
                'nid' => '1234567890131',
                'license_type_id' => 3,
                'license_type' => 'Master',
                'license_issue_date' => '2023-01-10',
                'date_of_birth' => '1992-05-20',
                'joining_date' => '2023-02-01',
                'present_address' => 'Niketon Gulshan, Dhaka-1212',
                'permanent_address' => 'Kushtia Sadar, Kushtia',
                'mobile' => '01711000014',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'available',
                'status' => 1,
            ],
            [
                'driver_name' => 'Azizur Rahman',
                'license_number' => 'DL-012-2024',
                'nid' => '1234567890132',
                'license_type_id' => 1,
                'license_type' => 'Professional',
                'license_issue_date' => '2015-04-22',
                'date_of_birth' => '1972-11-10',
                'joining_date' => '2015-05-01',
                'present_address' => 'Gulshan Society, Dhaka-1212',
                'permanent_address' => 'Pabna Sadar, Pabna',
                'mobile' => '01711000016',
                'department_id' => $defaultDept,
                'unit_id' => 1,
                'availability_status' => 'busy',
                'status' => 1,
            ],
        ];

        // Insert or update core drivers
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

        // Generate additional dummy drivers using Faker
        for ($i = 0; $i < 38; $i++) {
            $licenseTypes = [1, 2, 3];
            $licenseTypeNames = ['Professional', 'Heavy Vehicle', 'Master'];
            $availabilityStatuses = ['available', 'available', 'available', 'available', 'busy', 'on_leave'];
            
            $licenseTypeIndex = array_rand($licenseTypes);
            
            Driver::create([
                'driver_name' => $faker->name('male'),
                'license_number' => $faker->unique()->bothify('DL-###-####'),
                'nid' => $faker->numerify('#############'),
                'license_type_id' => $licenseTypes[$licenseTypeIndex],
                'license_type' => $licenseTypeNames[$licenseTypeIndex],
                'license_issue_date' => $faker->date('Y-m-d', '2020-01-01'),
                'date_of_birth' => $faker->date('Y-m-d', '1975-01-01'),
                'joining_date' => $faker->date('Y-m-d', '2023-01-01'),
                'present_address' => $faker->address,
                'permanent_address' => $faker->address,
                'mobile' => $faker->phoneNumber,
                'department_id' => $faker->randomElement($departments) ?: $defaultDept,
                'unit_id' => 1,
                'availability_status' => $faker->randomElement($availabilityStatuses),
                'status' => 1,
                'created_by' => 1,
            ]);
        }

        $this->command->info('Driver seeder completed successfully!');
        $this->command->info('Total core drivers: ' . count($drivers));
        $this->command->info('Total dummy drivers: 38');
        $this->command->info('Total drivers: 50');
    }
}
