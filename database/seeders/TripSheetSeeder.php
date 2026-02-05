<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Requisition;
use App\Models\TripSheet;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class TripSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if we have requisitions, vehicles, and drivers
        $requisitionCount = Requisition::count();
        $vehicleCount = Vehicle::count();
        $driverCount = Driver::count();

        if ($requisitionCount === 0 || $vehicleCount === 0 || $driverCount === 0) {
            $this->command->warn('Please run Vehicle, Driver, and Requisition seeders first.');
            return;
        }

        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $requisitions = Requisition::where('status', 'approved')
            ->orWhere('status', 'assigned')
            ->get();

        if ($requisitions->isEmpty()) {
            $requisitions = Requisition::all();
        }

        $tripStatuses = ['in_progress', 'completed', 'cancelled'];
        $locations = [
            'Head Office, Dhaka',
            'Gulshan Office',
            'Mirpur Factory',
            'Chittagong Port',
            'Airport Terminal 1',
            'Hotel Intercontinental',
            'Conference Center',
            'Industrial Area',
            'Shopping Mall',
            'Hospital'
        ];

        // Create completed trips
        $completedTrips = 15;
        for ($i = 0; $i < $completedTrips; $i++) {
            $vehicle = $vehicles->random();
            $driver = $drivers->random();
            $requisition = $requisitions->random();

            $startDate = now()->subDays(rand(1, 30));
            $endDate = $startDate->copy()->addHours(rand(2, 8));
            $startMeter = rand(10000, 50000);
            $endMeter = $startMeter + rand(50, 500);

            TripSheet::create([
                'trip_number' => 'TRIP-' . strtoupper(uniqid()),
                'requisition_id' => $requisition->id,
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'trip_start_time' => $startDate->format('Y-m-d H:i:s'),
                'trip_end_time' => $endDate->format('Y-m-d H:i:s'),
                'start_meter' => $startMeter,
                'closing_meter' => $endMeter,
                'start_location' => $locations[array_rand($locations)],
                'end_location' => $locations[array_rand($locations)],
                'start_km' => $startMeter,
                'end_km' => $endMeter,
                'total_km' => $endMeter - $startMeter,
                'remarks' => $this->getRandomRemark(),
                'status' => 'completed',
                'fuel_used' => rand(10, 50),
            ]);

            // Update vehicle and driver availability
            $vehicle->availability_status = 'available';
            $vehicle->save();
            $driver->availability_status = 'available';
            $driver->save();
        }

        // Create in-progress trips
        $inProgressTrips = 5;
        for ($i = 0; $i < $inProgressTrips; $i++) {
            $vehicle = $vehicles->random();
            $driver = $drivers->random();
            $requisition = $requisitions->random();

            $startDate = now()->subHours(rand(1, 12));
            $startMeter = rand(10000, 50000);

            TripSheet::create([
                'trip_number' => 'TRIP-' . strtoupper(uniqid()),
                'requisition_id' => $requisition->id,
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'start_date' => $startDate->format('Y-m-d'),
                'trip_start_time' => $startDate->format('Y-m-d H:i:s'),
                'start_meter' => $startMeter,
                'start_km' => $startMeter,
                'start_location' => $locations[array_rand($locations)],
                'end_location' => null,
                'end_date' => null,
                'trip_end_time' => null,
                'closing_meter' => null,
                'end_km' => null,
                'total_km' => null,
                'remarks' => 'Trip in progress',
                'status' => 'in_progress',
            ]);

            // Mark vehicle and driver as busy
            $vehicle->availability_status = 'busy';
            $vehicle->save();
            $driver->availability_status = 'busy';
            $driver->save();
        }

        // Create cancelled trips
        $cancelledTrips = 3;
        for ($i = 0; $i < $cancelledTrips; $i++) {
            $vehicle = $vehicles->random();
            $driver = $drivers->random();
            $requisition = $requisitions->random();

            $startDate = now()->subDays(rand(5, 20));

            TripSheet::create([
                'trip_number' => 'TRIP-' . strtoupper(uniqid()),
                'requisition_id' => $requisition->id,
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'start_date' => $startDate->format('Y-m-d'),
                'trip_start_time' => $startDate->format('Y-m-d H:i:s'),
                'start_meter' => rand(10000, 50000),
                'start_km' => rand(10000, 50000),
                'start_location' => $locations[array_rand($locations)],
                'end_location' => null,
                'end_date' => null,
                'trip_end_time' => null,
                'closing_meter' => null,
                'end_km' => null,
                'total_km' => null,
                'remarks' => 'Trip cancelled due to change in plans',
                'status' => 'cancelled',
            ]);

            // Update vehicle and driver availability
            $vehicle->availability_status = 'available';
            $vehicle->save();
            $driver->availability_status = 'available';
            $driver->save();
        }

        $this->command->info('TripSheetSeeder completed successfully!');
    }

    /**
     * Get a random remark for completed trips
     *
     * @return string
     */
    private function getRandomRemark()
    {
        $remarks = [
            'Client meeting completed successfully',
            'Airport drop-off completed',
            'Office equipment delivery done',
            'Site visit conducted',
            'Executive transport service',
            'Corporate event support',
            'Inter-office document delivery',
            'Business conference attendance',
            'Construction site visit',
            'Vendor meeting transport',
            'Quarterly review meeting',
            'Team building event transport',
            'Product launch support',
            'Customer site inspection',
            'Emergency supply delivery',
        ];

        return $remarks[array_rand($remarks)];
    }
}
