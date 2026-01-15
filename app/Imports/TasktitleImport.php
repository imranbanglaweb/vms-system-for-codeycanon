<?php

namespace App\Imports;

use App\Models\tasktitle;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
class TasktitleImport implements ToModel,  WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

      public function model(array $row)
    {
        return new tasktitle([
            'category_id' => $row['category_id'],
            'task_title'  => $row['task_title'],
            'created_by'  => Auth::id(), 
        ]);
    }
}
