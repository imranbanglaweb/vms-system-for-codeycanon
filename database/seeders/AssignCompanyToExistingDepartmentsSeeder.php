<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Database\Seeder;

class AssignCompanyToExistingDepartmentsSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();

        if ($company) {
            Department::whereNull('company_id')->update(['company_id' => $company->id]);

            $this->command->info('Assigned ' . Department::where('company_id', $company->id)->count() . ' departments to company: ' . $company->company_name);
        } else {
            $this->command->error('No company found to assign departments to');
        }
    }
}