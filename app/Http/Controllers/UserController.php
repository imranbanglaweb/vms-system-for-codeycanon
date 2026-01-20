<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ------------------------------------------------------------------
        INDEX PAGE VIEW
    ------------------------------------------------------------------ */
    public function index()
    {
        return view('admin.dashboard.users.index');
    }

     /* ------------------------------------------------------------------
        DATATABLE SERVER-SIDE DATA
    ------------------------------------------------------------------ */
  public function getData()
{
    $users = User::select(['id', 'user_name', 'name', 'email', 'user_image'])->orderBy('id', 'DESC');

    return DataTables::of($users)
        ->addIndexColumn() // DT_RowIndex
        // ->editColumn('user_image', function($row){
        //     $imageUrl = asset('images/default.png');

        //     if ($row->user_image && Storage::exists('users/'.$row->user_image)) {
        //         $imageUrl = asset('storage/users/'.$row->user_image);
        //     }

        //     return '<img src="'.$imageUrl.'" width="40" height="40" class="rounded-circle" onerror="this.src=\''.asset('images/default.png').'\';">';
        // })

       ->editColumn('user_image', function($row){
            return $row->user_image; // just the filename
        })


        ->addColumn('action', function ($row) {
            return '
                <button data-id="'.$row->id.'" class="btn btn-sm btn-danger deleteUser"><i class="fa fa-minus-circle"></i></button>
                <a href="'.route('users.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
            ';
        })

   

        ->rawColumns(['action','user_image'])
        ->order(function ($query) {
            // prevent ordering by DT_RowIndex
            if (request()->has('order')) {
                $order = request('order')[0];
                $columnIndex = $order['column'];
                $dir = $order['dir'];

                // map column index to actual DB column
                $columns = [
                    0 => 'id',         // DT_RowIndex
                    1 => 'user_name',
                    2 => 'name',
                    3 => 'email',
                ];

                if (isset($columns[$columnIndex])) {
                    $query->orderBy($columns[$columnIndex], $dir);
                }
            }
        })
        ->make(true);
}


    /* ------------------------------------------------------------------
        CREATE VIEW
    ------------------------------------------------------------------ */
    public function create()
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        $employees = Employee::orderBy('employee_order', 'ASC')->get();

        return view('admin.dashboard.users.create', compact('roles','employees'));
    }

    /* ------------------------------------------------------------------
        STORE USER
    ------------------------------------------------------------------ */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'user_type'   => 'required',
            'user_name'   => 'required',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|same:confirm-password',
            'roles'       => 'required',
            'user_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:8192',
        ]);

        if ($validator->fails()) {
            return response()->json(['success'=>false,'errors'=>$validator->errors()],422);
        }

        DB::beginTransaction();
        try {
            $employee = Employee::find($request->employee_id);

            $userData = [
                'name'          => $request->user_name,
                'employee_id'   => $request->employee_id,
                'user_name'     => $employee->employee_code,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'user_type'     => $request->user_type,
                'department_id' => $employee->department_id,
                'unit_id'       => $employee->unit_id,
                'created_by'    => Auth::id(),
            ];

            // if ($request->hasFile('user_image')) {
            //     $file = $request->file('user_image');
            //     $fileName = time().'_'.$file->getClientOriginalName();
            //     $file->storeAs('users', $fileName);
            //     $userData['user_image'] = $fileName;
            // }

            if ($request->hasFile('user_image')) {
                $file = $request->file('user_image');

                $fileName = time().'_'.$file->getClientOriginalName();

                // Save to your correct path
                $file->move(
                    public_path('admin_resource/assets/images/user_image'),
                    $fileName
                );

                $userData['user_image'] = $fileName;
            }


            $user = User::create($userData);
            $user->assignRole($request->roles);

            DB::commit();
            return response()->json(['success'=>true,'message'=>'User created successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$e->getMessage()],500);
        }
    }

    /* ------------------------------------------------------------------
        EDIT USER
    ------------------------------------------------------------------ */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $employees = Employee::orderBy('employee_order','ASC')->get();

        return view('admin.dashboard.users.edit', compact('user','roles','userRole','employees'));
    }

    /* ------------------------------------------------------------------
        UPDATE USER
    ------------------------------------------------------------------ */
    public function update(Request $request, $id)
        {
            $user = User::findOrFail($id);

            // Validate
            $request->validate([
                // 'name' => 'required|string|max:255',
                'employee_id' => 'required',
                'user_type'   => 'required',
                'user_name'   => 'required|string|max:255',
                'email'       => "required|email|unique:users,email,$id",
                'phone'       => 'nullable|string|max:20',
                'roles'       => 'required',
                'password'    => 'nullable|min:6|same:confirm-password',
                'user_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);

            // UPDATE FIELDS
                $user->employee_id = $request->employee_id;
                $user->user_type   = $request->user_type;
                $user->name        = $request->user_name;
                $user->email       = $request->email;
                $user->cell_phone       = $request->phone;


            $employee = Employee::find($request->employee_id);
                if ($employee) {
                    $user->department_id = $employee->department_id;
                    $user->unit_id       = $employee->unit_id;
                    $user->user_name     = $employee->employee_code;
                }

                 // OPTIONAL PASSWORD UPDATE
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }

            // If new image uploaded
            if ($request->hasFile('user_image')) {

                // Delete old image if exists

                if ($user->user_image) {
                    $oldImagePath = public_path('admin_resource/assets/images/user_image/'.$user->user_image);

                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // SAVE NEW IMAGE
                $file = $request->file('user_image');
                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(
                    public_path('admin_resource/assets/images/user_image'),
                    $fileName
                );

                $user->user_image = $fileName;
            }

            // Save updates
            $user->save();

            // UPDATE ROLE
            $user->syncRoles([$request->roles]);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully!'
            ]);
        }


    /* ------------------------------------------------------------------
        DELETE USER
    ------------------------------------------------------------------ */
        public function destroy($id)
        {
            $user = User::find($id);

            if (!$user) return response()->json(['error'=>'User not found'],404);

            if ($user->user_image) {
                $path = public_path('admin_resource/assets/images/user_image/'.$user->user_image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $user->delete();

            return response()->json(['success'=>'User deleted successfully']);
        }

        public function show($id)
        {
           
        }

       public function userprofile()
        {
            $user = Auth::user();
            $roles = Role::pluck('name')->all();
            $userRole = $user->roles->pluck('name','name')->all();
            $employees = Employee::orderBy('employee_order','ASC')->get();

            return view(
                'admin.dashboard.users.user-profile',
                compact('user','roles','userRole','employees')
            );
        }
        public function updateProfile(Request $request)
            {
                $user = Auth::user();

                // VALIDATION
                $request->validate([
                    'user_name'  => 'required|string|max:255',
                    'email'      => 'required|email|unique:users,email,' . $user->id,
                    'phone'      => 'nullable|string|max:20',
                    'password'   => 'nullable|min:6|same:confirm-password',
                    'user_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                ]);

                // BASIC UPDATE
                $user->name       = $request->user_name;
                $user->email      = $request->email;
                $user->cell_phone = $request->phone;

                // OPTIONAL PASSWORD UPDATE
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }

                // IMAGE UPDATE
                if ($request->hasFile('user_image')) {

                    // DELETE OLD IMAGE
                    if (!empty($user->user_image)) {
                        $oldPath = public_path(
                            'admin_resource/assets/images/user_image/' . $user->user_image
                        );

                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    // SAVE NEW IMAGE
                    $file = $request->file('user_image');
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    $file->move(
                        public_path('admin_resource/assets/images/user_image'),
                        $fileName
                    );

                    $user->user_image = $fileName;
                }

                $user->save();

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Profile updated successfully'
                ]);
            }
            public function profilepasswordupdate(Request $request)
            {

                $request->validate([
                    'password' => 'required|min:6|same:confirm-password',
                ]);

                $user = Auth::user();

                // UPDATE PASSWORD
                $user->password = Hash::make($request->password);
                $user->save();

                // FORCE LOGOUT (SECURITY)
                Auth::logout();

                // INVALIDATE SESSION
                $request->session()->invalidate();

                // REGENERATE CSRF TOKEN
                $request->session()->regenerateToken();

                return response()->json([
                    'status'   => 'logout',
                    'message'  => 'Password changed successfully. Please login again.',
                    'redirect' => route('login')   // ✅ route-based redirect
                ]);
            }



        
        

}