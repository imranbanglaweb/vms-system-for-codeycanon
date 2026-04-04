<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class AssignCompanyToExistingVehiclesSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();

        if ($company) {
            Vehicle::whereNull('company_id')->update(['company_id' => $company->id]);

            $this->command->info('Assigned ' . Vehicle::where('company_id', $company->id)->count() . ' vehicles to company: ' . $company->company_name);
        } else {
            $this->command->error('No company found to assign vehicles to');
        }
    }
}