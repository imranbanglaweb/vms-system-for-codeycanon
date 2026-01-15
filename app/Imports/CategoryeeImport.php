<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
class CategoryeeImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

      public function model(array $row)
    {

        // dd($row);
        return new Category([
            'unit_id'       => $row['unit'],
            'department_id' => $row['department'], 
            'location_id'   => $row['location'], 
            'category_name' => $row['category'], 
            'category_slug' => \Str::slug($row['category']),
            'created_by' => Auth::id(), 
        ]);
    }
}
