<?php
namespace App\Imports;

use App\Models\Taskfileimport;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
class TaskImport implements ToModel,  WithHeadingRow
{
   


  // protected $category_id;
  // protected $title;



  //   public function __construct($category_id,$title)
  //   {
  //       $this->category_id = $category_id;
  //       $this->title = $title;
  //   }





 // public function collection(Collection $rows)
 //    {
 //        foreach ($rows as $row)
 //        {
 //           $user = Taskfileimport::create([
 //            'department_id'         => $row['department_id'],
 //            'category_id'           => $row['module_id'],
 //            'title'                 => $row['particular_id'],
 //            // 'title'                 => $title,
 //            // 'department_name'       => $department_name,
 //            'quantity'              => $row['quantity'],
 //            'task_channel'          => $row['task_channel'],
 //            'task_start_date'       => $row['task_start_date'],
 //            'task_due_date'         => $row['task_due_date'],
 //            'priority'              => $row['priority'],
 //            'work_status'           => $row['work_status'],
 //            // 'solved_process'        => $row['solved_process'],
 //            'task_details'          => $row['task_details'],
 //            'task_remarks'          => $row['task_remarks'],
 //            // 'assigned_to'           => $row['assigned_to'],
 //            'created_by'            => Auth::id(), 
 //           ]);

 //           // Customer::create([
 //           //     'customer_name' => $row[0],
 //           //     'gender' => $row[1],
 //           //     'address' => $row[2],
 //           //     'city' => $row[3],
 //           //     'postal_code' => $row[4],
 //           //     'country' => $row[5],
 //           // ]);
 //           // $myString = $row[8];
 //           // $myArray = explode(',', $myString);
 //           // foreach ($myArray as $value) {
 //           //     Courses::create([
 //           //          'user_id' => $user->id,
 //           //          'course_name' => $value,
 //           //     ]);
 //           // }
 //      }
 //   }

    
      public function model(array $row)
    {

        // $category_id = $this->category_id;
        // $title = $this->title;
        // $employee_id = DB::table('employees')
        //                     ->whereIn('employee_id',$row['employee_id'])
        //                     ->get();

        $employee_list = Employee::whereIn('employee_id',[$row['employee_id']])
                        ->first();


        $user_list = User::whereIn('user_name',[$row['employee_id']])
                        ->first();

        // return dd($employee_list->id);

        // return dd($row['employee_id']);



$date = Carbon::now();

        return new Taskfileimport([
            'department_id'         => $row['department'],
            'category_id'           => $row['module_id'],
            'title'                 => $row['particular_id'],
            // 'title'                 => $title,
            // 'department_name'       => $department_name,
            'quantity'              => $row['quantity'],
            // 'support_id'            => $row['task_channel'],
            // 'task_start_date'       => $row['task_start_date'],
            'task_start_date' => $this->transformDate($row['task_start_date']),
            'task_due_date' => $this->transformDate($row['task_due_date']),
            'issue_type_id'         => $row['priority'],
            'issue_status'          => $row['work_status'],
            // 'solved_process'        => $row['solved_process'],
            'task_details'          => $row['task_details'],
            // 'remarks'               => $row['task_remarks'],
            'assigned_to'         => $employee_list->id,
            'employee_id'         => $employee_list->id,
            'issue_date'          => $date->format('y-m-d'),
            'unit_id'             => Auth::user()->unit_id,
            // 'company_id'          => $request->company_id,
            'location_id'         => Auth::user()->location_id,
            'assign_task_status'  => Auth::id(),
            'status_changed_by'   => Auth::id(),
            'changed_date'        => Carbon::now(),
            'created_by'          => $user_list->id, 
        ]);
    }
   private function transformDate($value)
    {
        if (is_numeric($value)) {
            // If the date is numeric, it's an Excel date (number of days since 1900-01-01)
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        // If it's already a string (formatted date), try to parse it with Carbon
        return Carbon::parse($value)->format('Y-m-d');
    }





}
