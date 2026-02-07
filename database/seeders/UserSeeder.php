<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Driver;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ================= ROLES =================
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole = Role::where('name', 'Admin')->first();
        $deptHeadRole   = Role::where('name', 'Department Head')->first();
        $transportRole  = Role::where('name', 'Transport')->first();
        $employeeRole   = Role::where('name', 'Employee')->first();
        $driverRole     = Role::where('name', 'Driver')->first();

        // Get first records for linking
        $firstEmployee = Employee::first();
        $firstDepartment = Department::first();
        $firstUnit = Unit::first();
        $firstLocation = Location::first();

        $dummyImage = 'default.png';

        // ================= SUPER ADMIN =================
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@demo.com'],
            [
                'name' => 'Super Admin',
                'user_name' => 'SA001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'super_user',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000001',
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // ================= ADMIN =================
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'System Admin',
                'user_name' => 'AD001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'admin',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000002',
            ]
        );
        $admin->assignRole($adminRole);

        // ================= TRANSPORT MANAGER =================
        $transport = User::firstOrCreate(
            ['email' => 'transport@demo.com'],
            [
                'name' => 'Transport Manager',
                'user_name' => 'TM001',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'super_user',
                'employee_id' => $firstEmployee ? $firstEmployee->id : null,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : null,
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => '01700000004',
            ]
        );
        $transport->assignRole($transportRole);

        // ================= EMPLOYEE USERS (Linked to Employees) =================
        
        // Get all employees with their emails
        $employees = Employee::whereIn('email', [
            'employee@demo.com',
            'john.doe@demo.com',
            'jane.smith@demo.com',
            'mike.johnson@demo.com',
            'sarah.williams@demo.com',
            'alex.brown@demo.com',
        ])->get();

        foreach ($employees as $emp) {
            // Create or update user for each employee
            $user = User::firstOrCreate(
                ['email' => $emp->email],
                [
                    'name' => $emp->name,
                    'user_name' => $emp->employee_code,
                    'password' => Hash::make('password'),
                    'status' => 1,
                    'user_type' => 'normal_user',
                    'employee_id' => $emp->id,
                    'company_id' => 1,
                    'department_id' => $emp->department_id,
                    'unit_id' => $emp->unit_id,
                    'location_id' => $emp->location_id,
                    'user_image' => $dummyImage,
                    'cell_phone' => $emp->phone ?? '01700000000',
                ]
            );
            
            // Assign employee role
            $user->syncRoles([$employeeRole]);
            
            $this->command->info("Created user for employee: {$emp->name} ({$emp->email})");
        }

        // ================= DEPARTMENT HEAD USERS =================
        
        // Create department head users based on assigned heads
        $departmentHeads = [
            'HR' => 'Demo Employee',
            'IT' => 'John Doe',
            'Accounts' => 'Jane Smith',
            'Operations' => 'Mike Johnson',
            'Finance' => 'Sarah Williams',
        ];

        foreach ($departmentHeads as $deptName => $empName) {
            $department = Department::where('department_name', $deptName)->first();
            if ($department && $department->headEmployee) {
                $headEmployee = $department->headEmployee;
                
                // Create or update user as department head
                $headUser = User::firstOrCreate(
                    ['email' => $headEmployee->email],
                    [
                        'name' => $headEmployee->name,
                        'user_name' => $headEmployee->employee_code,
                        'password' => Hash::make('password'),
                        'status' => 1,
                        'user_type' => 'department_head',
                        'employee_id' => $headEmployee->id,
                        'company_id' => 1,
                        'department_id' => $department->id,
                        'unit_id' => $headEmployee->unit_id,
                        'location_id' => $headEmployee->location_id,
                        'user_image' => $dummyImage,
                        'cell_phone' => $headEmployee->phone ?? '01700000000',
                    ]
                );
                
                // Assign department head role
                $headUser->syncRoles([$deptHeadRole, $employeeRole]);
                
                $this->command->info("Created department head user: {$headEmployee->name} for {$deptName}");
            }
        }

        // ================= DRIVER USERS WITH EMPLOYEE RECORDS =================
        
        // Driver data with employee information
        $driverData = [
            [
                'license_number' => 'DL-001-2024',
                'name' => 'Mohammad Karim Ahmed',
                'email' => 'karim.ahmed@demo.com',
                'username' => 'DR001',
                'mobile' => '01711000001',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-002-2024',
                'name' => 'Abdul Rahim',
                'email' => 'abdul.rahim@demo.com',
                'username' => 'DR002',
                'mobile' => '01711000002',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-003-2024',
                'name' => 'Jamal Hossain',
                'email' => 'jamal.hossain@demo.com',
                'username' => 'DR003',
                'mobile' => '01711000003',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-004-2024',
                'name' => 'Salam Khan',
                'email' => 'salam.khan@demo.com',
                'username' => 'DR004',
                'mobile' => '01711000004',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-005-2024',
                'name' => 'Rafiq Islam',
                'email' => 'rafiq.islam@demo.com',
                'username' => 'DR005',
                'mobile' => '01711000005',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-006-2024',
                'name' => 'Mostafa Ali',
                'email' => 'mostafa.ali@demo.com',
                'username' => 'DR006',
                'mobile' => '01711000006',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-007-2024',
                'name' => 'Harun Or Rashid',
                'email' => 'harun.rashid@demo.com',
                'username' => 'DR007',
                'mobile' => '01711000007',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-008-2024',
                'name' => 'Anwar Hossain',
                'email' => 'anwar.hossain@demo.com',
                'username' => 'DR008',
                'mobile' => '01711000008',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-009-2024',
                'name' => 'Ziaur Rahman',
                'email' => 'ziaur.rahman@demo.com',
                'username' => 'DR009',
                'mobile' => '01711000010',
                'designation' => 'Driver',
            ],
            [
                'license_number' => 'DL-010-2024',
                'name' => 'Monir Hossain',
                'email' => 'monir.hossain@demo.com',
                'username' => 'DR010',
                'mobile' => '01711000012',
                'designation' => 'Driver',
            ],
        ];

        foreach ($driverData as $driver) {
            // Get the driver record
            $driverRecord = Driver::where('license_number', $driver['license_number'])->first();
            
            // Create employee record for the driver
            $employee = Employee::firstOrCreate(
                ['email' => $driver['email']],
                [
                    'name' => $driver['name'],
                    'employee_code' => $driver['username'],
                    'email' => $driver['email'],
                    'phone' => $driver['mobile'],
                    'designation' => $driver['designation'],
                    'company_id' => 1,
                    'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                    'unit_id' => $firstUnit ? $firstUnit->id : 1,
                    'location_id' => $firstLocation ? $firstLocation->id : 1,
                    'employee_type' => 'driver',
                    'join_date' => now()->format('Y-m-d'),
                    'status' => 1,
                    'photo' => $dummyImage,
                    'present_address' => $driverRecord ? $driverRecord->present_address : 'Dhaka, Bangladesh',
                    'permanent_address' => $driverRecord ? $driverRecord->permanent_address : 'Dhaka, Bangladesh',
                ]
            );
            
            // Create or update user for driver
            $driverUser = User::firstOrCreate(
                ['email' => $driver['email']],
                [
                    'name' => $driver['name'],
                    'user_name' => $driver['username'],
                    'password' => Hash::make('password'),
                    'status' => 1,
                    'user_type' => 'driver',
                    'employee_id' => $employee->id,
                    'company_id' => 1,
                    'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                    'unit_id' => $firstUnit ? $firstUnit->id : 1,
                    'location_id' => $firstLocation ? $firstLocation->id : 1,
                    'user_image' => $dummyImage,
                    'cell_phone' => $driver['mobile'],
                ]
            );
            
            // Create driver role if doesn't exist
            if (!$driverRole) {
                $driverRole = Role::firstOrCreate(['name' => 'Driver', 'guard_name' => 'web']);
            }
            
            // Assign driver role
            $driverUser->syncRoles([$driverRole]);
            
            $this->command->info("Created driver user with employee record: {$driver['name']} ({$driver['email']}) | Password: password");
        }

        // ================= SUMMARY =================
        $this->command->info('');
        $this->command->info('User seeding completed!');
        $this->command->info('========================================');
        $this->command->info('System Users:');
        $this->command->info('  - superadmin@demo.com / password (Super Admin)');
        $this->command->info('  - admin@demo.com / password (Admin)');
        $this->command->info('  - transport@demo.com / password (Transport Manager)');
        $this->command->info('');
        $this->command->info('Driver Users with Employee Records:');
        $this->command->info('  - karim.ahmed@demo.com / password');
        $this->command->info('  - abdul.rahim@demo.com / password');
        $this->command->info('  - Jamal.hossain@demo.com / password');
        $this->command->info('  - salam.khan@demo.com / password');
        $this->command->info('  - rafiq.islam@demo.com / password');
        $this->command->info('  - mostafa.ali@demo.com / password');
        $this->command->info('  - harun.rashid@demo.com / password');
        $this->command->info('  - anwar.hossain@demo.com / password');
        $this->command->info('  - ziaur.rahman@demo.com / password');
        $this->command->info('  - monir.hossain@demo.com / password');
        $this->command->info('========================================');
    }
}
