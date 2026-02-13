<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requisition;
use Faker\Factory as Faker;

class RequisitionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // ================= PENDING REQUISITION =================
        Requisition::updateOrCreate(
            ['requisition_number' => 'REQ-00001'],
            [
                'requested_by' => 1,
                'department_id' => 1,
                'unit_id' => 1,
                'vehicle_type' => 1,
                'from_location' => 'Head Office',
                'to_location' => 'Factory',
                'requisition_date' => now(),
                'travel_date' => now()->addDay(),
                'number_of_passenger' => 2,
                'purpose' => 'Official Visit',
                'department_status' => 'Pending',
                'transport_status' => 'Pending',
                'status' => 1,
                'created_by' => 1,
            ]
        );

        // ================= DEPARTMENT APPROVED, TRANSPORT PENDING =================
        Requisition::updateOrCreate(
            ['requisition_number' => 'REQ-00002'],
            [
                'requested_by' => 1,
                'department_id' => 2,
                'unit_id' => 1,
                'vehicle_type' => 2,
                'from_location' => 'Head Office',
                'to_location' => 'Warehouse',
                'requisition_date' => now(),
                'travel_date' => now()->addDays(2),
                'number_of_passenger' => 3,
                'purpose' => 'Stock Inspection',
                'department_status' => 'Approved',
                'transport_status' => 'Pending',
                'status' => 2,
                'created_by' => 1,
            ]
        );

        // ================= DEPARTMENT REJECTED =================
        Requisition::updateOrCreate(
            ['requisition_number' => 'REQ-00003'],
            [
                'requested_by' => 1,
                'department_id' => 3,
                'unit_id' => 1,
                'vehicle_type' => 1,
                'from_location' => 'Head Office',
                'to_location' => 'Branch Office',
                'requisition_date' => now(),
                'travel_date' => now()->addDays(3),
                'number_of_passenger' => 1,
                'purpose' => 'Personal Work',
                'department_status' => 'Rejected',
                'transport_status' => 'Pending',
                'status' => 3,
                'created_by' => 1,
            ]
        );

        // ================= DEPARTMENT & TRANSPORT APPROVED =================
        Requisition::updateOrCreate(
            ['requisition_number' => 'REQ-00004'],
            [
                'requested_by' => 1,
                'department_id' => 1,
                'unit_id' => 1,
                'vehicle_type' => 3,
                'from_location' => 'Head Office',
                'to_location' => 'Airport',
                'requisition_date' => now(),
                'travel_date' => now()->addDays(5),
                'number_of_passenger' => 4,
                'purpose' => 'Client Meeting',
                'department_status' => 'Approved',
                'transport_status' => 'Approved',
                'status' => 4,
                'created_by' => 1,
            ]
        );

        // ================= GM APPROVED (COMPLETED) =================
        Requisition::updateOrCreate(
            ['requisition_number' => 'REQ-00005'],
            [
                'requested_by' => 1,
                'department_id' => 2,
                'unit_id' => 2,
                'vehicle_type' => 4,
                'from_location' => 'Head Office',
                'to_location' => 'City Mall',
                'requisition_date' => now(),
                'travel_date' => now()->subDay(),
                'number_of_passenger' => 5,
                'purpose' => 'Team Outing',
                'department_status' => 'Approved',
                'transport_status' => 'Approved',
                'status' => 5,
                'created_by' => 1,
            ]
        );

        // ================= GENERATE 95 MORE RANDOM REQUISITIONS =================
        for ($i = 0; $i < 95; $i++) {
            $requisitionNumber = $faker->unique()->bothify('REQ-#####');
            
            // Random status combinations
            $deptStatuses = ['Pending', 'Approved', 'Rejected'];
            $transportStatuses = ['Pending', 'Approved', 'Rejected'];
            
            $deptStatus = $faker->randomElement($deptStatuses);
            
            // If department is rejected, transport should be rejected
            if ($deptStatus === 'Rejected') {
                $transportStatus = 'Rejected';
            } else {
                $transportStatus = $faker->randomElement($transportStatuses);
            }
            
            // Overall status based on combinations
            if ($deptStatus === 'Rejected' || $transportStatus === 'Rejected') {
                $status = 3; // Rejected
            } elseif ($deptStatus === 'Pending') {
                $status = 1; // Pending
            } elseif ($transportStatus === 'Pending') {
                $status = 2; // Dept Approved
            } else {
                $status = 4; // Transport Approved
            }

            Requisition::updateOrCreate(
                ['requisition_number' => $requisitionNumber],
                [
                    'requested_by' => 1,
                    'department_id' => $faker->numberBetween(1, 10),
                    'unit_id' => $faker->numberBetween(1, 6),
                    'vehicle_type' => $faker->numberBetween(1, 8),
                    'from_location' => $faker->city,
                    'to_location' => $faker->city,
                    'requisition_date' => $faker->dateTimeBetween('-1 month', 'now'),
                    'travel_date' => $faker->dateTimeBetween('now', '+1 month'),
                    'number_of_passenger' => $faker->numberBetween(1, 5),
                    'purpose' => $faker->sentence,
                    'department_status' => $deptStatus,
                    'transport_status' => $transportStatus,
                    'status' => $status,
                    'created_by' => 1,
                ]
            );
        }

        $this->command->info('Requisition seeding completed!');
        $this->command->info('Created/Updated 100 requisitions with various status combinations.');
    }
}
