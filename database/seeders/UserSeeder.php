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

        // ================= SUPER ADMIN EMPLOYEE =================
        $superAdminEmpData = [
            'name' => 'Super Admin User',
            'email' => 'superadmin@vms.com',
            'employee_code' => 'SA001',
            'mobile' => '01700000001',
            'designation' => 'Super Administrator',
            'department_id' => 1,
        ];
        
        $superAdminEmp = Employee::firstOrCreate(
            ['email' => $superAdminEmpData['email']],
            [
                'name' => $superAdminEmpData['name'],
                'employee_code' => $superAdminEmpData['employee_code'],
                'email' => $superAdminEmpData['email'],
                'phone' => $superAdminEmpData['mobile'],
                'designation' => $superAdminEmpData['designation'],
                'company_id' => 1,
                'department_id' => $superAdminEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => 'Dhaka, Bangladesh',
                'permanent_address' => 'Dhaka, Bangladesh',
            ]
        );

        // ================= SUPER ADMIN =================
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@vms.com'],
            [
                'name' => $superAdminEmpData['name'],
                'user_name' => $superAdminEmpData['employee_code'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'super_user',
                'employee_id' => $superAdminEmp->id,
                'company_id' => 1,
                'department_id' => $superAdminEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => $superAdminEmpData['mobile'],
            ]
        );
        $superAdmin->assignRole($superAdminRole);
        $this->command->info("Created Super Admin: superadmin@vms.com / password");

        // ================= ADMIN EMPLOYEE =================
        $adminEmpData = [
            'name' => 'System Admin User',
            'email' => 'admin@garibondhu360.com',
            'employee_code' => 'AD001',
            'mobile' => '01700000002',
            'designation' => 'System Administrator',
            'department_id' => 1,
        ];
        
        $adminEmp = Employee::firstOrCreate(
            ['email' => $adminEmpData['email']],
            [
                'name' => $adminEmpData['name'],
                'employee_code' => $adminEmpData['employee_code'],
                'email' => $adminEmpData['email'],
                'phone' => $adminEmpData['mobile'],
                'designation' => $adminEmpData['designation'],
                'company_id' => 1,
                'department_id' => $adminEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => 'Dhaka, Bangladesh',
                'permanent_address' => 'Dhaka, Bangladesh',
            ]
        );

        // ================= ADMIN =================
        $admin = User::firstOrCreate(
            ['email' => 'admin@garibondhu360.com'],
            [
                'name' => $adminEmpData['name'],
                'user_name' => $adminEmpData['employee_code'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'admin',
                'employee_id' => $adminEmp->id,
                'company_id' => 1,
                'department_id' => $adminEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => $adminEmpData['mobile'],
            ]
        );
        $admin->assignRole($adminRole);
        $this->command->info("Created Admin: admin@garibondhu360.com / password");

        // ================= TRANSPORT ADMIN EMPLOYEE =================
        $transportEmpData = [
            'name' => 'Transport Admin User',
            'email' => 'transport@garibondhu360.com',
            'employee_code' => 'TA001',
            'mobile' => '01700000003',
            'designation' => 'Transport Manager',
            'department_id' => 9, // Transport department
        ];
        
        $transportEmp = Employee::firstOrCreate(
            ['email' => $transportEmpData['email']],
            [
                'name' => $transportEmpData['name'],
                'employee_code' => $transportEmpData['employee_code'],
                'email' => $transportEmpData['email'],
                'phone' => $transportEmpData['mobile'],
                'designation' => $transportEmpData['designation'],
                'company_id' => 1,
                'department_id' => $transportEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => 'Dhaka, Bangladesh',
                'permanent_address' => 'Dhaka, Bangladesh',
            ]
        );

        // ================= TRANSPORT ADMIN =================
        $transport = User::firstOrCreate(
            ['email' => 'transport@garibondhu360.com'],
            [
                'name' => $transportEmpData['name'],
                'user_name' => $transportEmpData['employee_code'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'super_user',
                'employee_id' => $transportEmp->id,
                'company_id' => 1,
                'department_id' => $transportEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => $transportEmpData['mobile'],
            ]
        );
        $transport->assignRole($transportRole);
        $this->command->info("Created Transport Admin: transport@garibondhu360.com / password");

        // ================= DEPARTMENT HEAD EMPLOYEE =================
        $deptHeadEmpData = [
            'name' => 'Department Head User',
            'email' => 'depthead@garibondhu360.com',
            'employee_code' => 'DH001',
            'mobile' => '01700000004',
            'designation' => 'Department Head',
            'department_id' => 1,
        ];
        
        $deptHeadEmp = Employee::firstOrCreate(
            ['email' => $deptHeadEmpData['email']],
            [
                'name' => $deptHeadEmpData['name'],
                'employee_code' => $deptHeadEmpData['employee_code'],
                'email' => $deptHeadEmpData['email'],
                'phone' => $deptHeadEmpData['mobile'],
                'designation' => $deptHeadEmpData['designation'],
                'company_id' => 1,
                'department_id' => $deptHeadEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => 'Dhaka, Bangladesh',
                'permanent_address' => 'Dhaka, Bangladesh',
            ]
        );

        // ================= DEPARTMENT HEAD =================
        $deptHead = User::firstOrCreate(
            ['email' => 'depthead@garibondhu360.com'],
            [
                'name' => $deptHeadEmpData['name'],
                'user_name' => $deptHeadEmpData['employee_code'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'department_head',
                'employee_id' => $deptHeadEmp->id,
                'company_id' => 1,
                'department_id' => $deptHeadEmpData['department_id'],
                'unit_id' => $firstUnit ? $firstUnit->id : null,
                'location_id' => $firstLocation ? $firstLocation->id : null,
                'user_image' => $dummyImage,
                'cell_phone' => $deptHeadEmpData['mobile'],
            ]
        );
        $deptHead->assignRole($deptHeadRole);
        $this->command->info("Created Department Head: depthead@garibondhu360.com / password");

        // ================= EMPLOYEE USER =================
        // Create employee record first, then user
        $employeeData = [
            'name' => 'John Doe',
            'email' => 'employee@garibondhu360.com',
            'employee_code' => 'EMP001',
            'mobile' => '01700000005',
            'designation' => 'Officer',
        ];
        
        // Create employee record for the employee user
        $employeeRecord = Employee::firstOrCreate(
            ['email' => $employeeData['email']],
            [
                'name' => $employeeData['name'],
                'employee_code' => $employeeData['employee_code'],
                'email' => $employeeData['email'],
                'phone' => $employeeData['mobile'],
                'designation' => $employeeData['designation'],
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => 'Dhaka, Bangladesh',
                'permanent_address' => 'Dhaka, Bangladesh',
            ]
        );
        
        // Create user for employee
        $employeeUser = User::firstOrCreate(
            ['email' => $employeeData['email']],
            [
                'name' => $employeeData['name'],
                'user_name' => $employeeData['employee_code'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'normal_user',
                'employee_id' => $employeeRecord->id,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'user_image' => $dummyImage,
                'cell_phone' => $employeeData['mobile'],
            ]
        );
        $employeeUser->assignRole($employeeRole);
        $this->command->info("Created Employee User: employee@garibondhu360.com / password");

        // ================= ADDITIONAL EMPLOYEE USER =================
        // Create additional employee record first, then user
        $employeeData2 = [
            'name' => 'Jane Smith',
            'email' => 'employee2@garibondhu360.com',
            'employee_code' => 'EMP500',
            'mobile' => '01700000006',
            'designation' => 'Senior Officer',
        ];
        
        // Create employee record for the additional employee user
        $employeeRecord2 = Employee::firstOrCreate(
            ['email' => $employeeData2['email']],
            [
                'name' => $employeeData2['name'],
                'employee_code' => $employeeData2['employee_code'],
                'email' => $employeeData2['email'],
                'phone' => $employeeData2['mobile'],
                'designation' => $employeeData2['designation'],
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => 'Dhaka, Bangladesh',
                'permanent_address' => 'Dhaka, Bangladesh',
            ]
        );
        
        // Create user for additional employee
        $employeeUser2 = User::firstOrCreate(
            ['email' => $employeeData2['email']],
            [
                'name' => $employeeData2['name'],
                'user_name' => $employeeData2['employee_code'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'normal_user',
                'employee_id' => $employeeRecord2->id,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'user_image' => $dummyImage,
                'cell_phone' => $employeeData2['mobile'],
            ]
        );
        $employeeUser2->assignRole($employeeRole);
        $this->command->info("Created Employee User: employee2@garibondhu360.com / password");

        // ================= DRIVER USER (ONLY ONE) =================
        // Create only one driver with employee record
        $driverData = [
            'license_number' => 'DL-001-2024',
            'name' => 'Mohammad Karim Ahmed',
            'email' => 'driver@garibondhu360.com',
            'username' => 'DR001',
            'mobile' => '01711000001',
            'designation' => 'Driver',
        ];

        // Get the driver record
        $driverRecord = Driver::where('license_number', $driverData['license_number'])->first();
        
        // Create employee record for the driver
        $employeeDriver = Employee::firstOrCreate(
            ['email' => $driverData['email']],
            [
                'name' => $driverData['name'],
                'employee_code' => $driverData['username'],
                'email' => $driverData['email'],
                'phone' => $driverData['mobile'],
                'designation' => $driverData['designation'],
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'join_date' => now()->format('Y-m-d'),
                'status' => 1,
                'photo' => $dummyImage,
                'present_address' => $driverRecord ? $driverRecord->present_address : 'Dhaka, Bangladesh',
                'permanent_address' => $driverRecord ? $driverRecord->permanent_address : 'Dhaka, Bangladesh',
            ]
        );
        
        // Create or update user for driver
        $driverUser = User::firstOrCreate(
            ['email' => $driverData['email']],
            [
                'name' => $driverData['name'],
                'user_name' => $driverData['username'],
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'driver',
                'employee_id' => $employeeDriver->id,
                'company_id' => 1,
                'department_id' => $firstDepartment ? $firstDepartment->id : 1,
                'unit_id' => $firstUnit ? $firstUnit->id : 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'user_image' => $dummyImage,
                'cell_phone' => $driverData['mobile'],
            ]
        );
        
        // Create driver role if doesn't exist
        if (!$driverRole) {
            $driverRole = Role::firstOrCreate(['name' => 'Driver', 'guard_name' => 'web']);
        }
        
        // Assign driver role
        $driverUser->syncRoles([$driverRole]);
        $this->command->info("Created Driver User: driver@garibondhu360.com / password");

        // ================= SUMMARY =================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('User seeding completed!');
        $this->command->info('========================================');
        $this->command->info('Users with Employee Records:');
        $this->command->info('  1. superadmin@vms.com / password (Super Admin | SA001)');
        $this->command->info('  2. admin@garibondhu360.com / password (Admin | AD001)');
        $this->command->info('  3. transport@garibondhu360.com / password (Transport Admin | TA001)');
        $this->command->info('  4. depthead@garibondhu360.com / password (Department Head | DH001)');
        $this->command->info('  5. employee@garibondhu360.com / password (Employee | EMP001)');
        $this->command->info('  6. employee2@garibondhu360.com / password (Employee | EMP500)');
        $this->command->info('  7. driver@garibondhu360.com / password (Driver | DR001)');
        $this->command->info('========================================');
    }
}
