<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Location;
use App\Models\CustomDashboard;
use App\Models\Department;
use App\Models\Role;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /*
    |-------------------------------------------------
    | LIST
    |-------------------------------------------------
    */
    public function index()
    {
        if (hasPermission('employee_view_all')) {

            $employees = Employee::with(['user','location','department','role'])
                ->latest()
                ->get();

        } elseif (hasPermission('employee_view_own')) {

            $employees = Employee::with(['user','location','department','role'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

        } else {
            return response()->view('errors.no-access');
        }

        return view('employees.index', compact('employees'));
    }

    /*
    |-------------------------------------------------
    | CREATE
    |-------------------------------------------------
    */
    public function create()
    {
        if (!hasPermission('employee_add')) {
            return response()->view('errors.no-access');
        }

        $locations   = Location::orderBy('name')->get();
        $departments = Department::orderBy('dept_name')->get();
        if (Auth::user()->role_id == 1) {
        $roles = Role::where('id', '!=', 1)
            ->where('slug', '!=', 'super-admin')
            ->orderBy('name')
            ->get();
    } else {
        $roles = Role::where('slug', 'employee')
            ->orderBy('name')
            ->get();
    }
        $customdashboards  = CustomDashboard::orderBy('dash_name')->get();

        return view('employees.create', compact('locations','departments','roles','customdashboards'));
    }

    /*
    |-------------------------------------------------
    | STORE
    |-------------------------------------------------
    */
  public function store(Request $request)
{
    if (!hasPermission('employee_add')) {
        return response()->view('errors.no-access');
    }

    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|max:255|unique:users,email',
        'password'        => 'required|string|min:6|max:50',
        'mobile'          => 'required|digits:10',
        'address'         => 'required|string|max:500',
        'location_id'     => 'required|exists:locations,id',
        'department_id'   => 'required|exists:departments,id',
        'role_id'         => 'required|exists:roles,id',
        'gender'          => 'nullable|in:male,female,other',
        'joining_date'    => 'required|date',
        'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'dashboard_ids'   => 'nullable|array',
        'dashboard_ids.*' => 'exists:custom_dashboards,id',
    ]);

    /* -------------------------------------------------
     | DEPARTMENT VALIDATION
     |------------------------------------------------- */

    $department = Department::where('id', $request->department_id)
        ->where('location_id', $request->location_id)
        ->first();

    if (!$department) {
        return back()
            ->withInput()
            ->withErrors([
                'department_id' =>
                    'Selected department does not belong to selected location.'
            ]);
    }

    /* -------------------------------------------------
     | ROLE
     |------------------------------------------------- */

    $role = Role::find($request->role_id);

    /* -------------------------------------------------
     | USER CREATE
     |------------------------------------------------- */

    $user = User::create([
        'user_type'     => 'employee',
        'role_id'       => $request->role_id,
        'name'          => $request->name,
        'email'         => $request->email,
        'mobile'        => $request->mobile,
        'address'       => $request->address,
        'password'      => Hash::make($request->password),
        'show_password' => $request->password,
    ]);

    /* -------------------------------------------------
     | IMAGE UPLOAD
     |------------------------------------------------- */

    $imageName = null;

    if ($request->hasFile('image')) {

        $image = $request->file('image');

        /*
         * Use a separate employee image directory.
         * This avoids the existing employees directory
         * write problem.
         */
        $uploadDirectory = public_path('uploads/employee_images');

        /*
         * Create directory if it does not exist.
         */
        if (!is_dir($uploadDirectory)) {
            @mkdir($uploadDirectory, 0777, true);
        }

        /*
         * Verify directory.
         */
        if (!is_dir($uploadDirectory)) {

            // Delete user if image directory cannot be created
            $user->delete();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create employee image directory.'
                );
        }

        /*
         * Generate unique image name.
         */
        $imageName =
            'employee_' .
            time() .
            '_' .
            uniqid() .
            '.' .
            $image->getClientOriginalExtension();

        $imagePath =
            $uploadDirectory . DIRECTORY_SEPARATOR . $imageName;

        /*
         * Read uploaded temporary file.
         */
        $imageContent = file_get_contents($image->getRealPath());

        if ($imageContent === false) {

            $user->delete();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to read uploaded image.'
                );
        }

        /*
         * Write image directly.
         * Do not use $image->move().
         */
        $written = @file_put_contents(
            $imagePath,
            $imageContent
        );

        if ($written === false) {

            $user->delete();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to save employee image.'
                );
        }

        /*
         * Store relative path in database.
         */
        $imageName = '../employee_images/' . $imageName;
    }

    /* -------------------------------------------------
     | EMPLOYEE CREATE
     |------------------------------------------------- */

    $employee = Employee::create([
        'user_id'       => $user->id,
        'location_id'   => $request->location_id,
        'department_id' => $request->department_id,
        'role_id'       => $request->role_id,
        'gender'        => $request->gender,
        'joining_date'  => $request->joining_date,
        'image'         => $imageName,
    ]);

    /* -------------------------------------------------
     | CUSTOM DASHBOARD ASSIGN
     |------------------------------------------------- */

    if ($employee && $request->filled('dashboard_ids')) {

        $insertData = [];

        foreach ($request->dashboard_ids as $dashboardId) {

            $insertData[] = [
                'employee_id'  => $employee->id,
                'dashboard_id' => $dashboardId,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        if (!empty($insertData)) {
            \DB::table('employee_dashboards')
                ->insert($insertData);
        }
    }

    /* -------------------------------------------------
     | ACTIVITY
     |------------------------------------------------- */

    Activity::create([
        'user_id'     => Auth::id(),
        'table_name'  => 'users',
        'table_id'    => $user->id,
        'operation'   => 'create',
        'description' =>
            'User "' . $user->name . '" created as employee',
    ]);

    return redirect()
        ->route('employees.index')
        ->with('success', 'Employee added successfully');
}

    /*
    |-------------------------------------------------
    | SHOW
    |-------------------------------------------------
    */
    // public function show($id)
    // {
    //     if (!hasPermission('employee_view_all') && !hasPermission('employee_view_own')) {
    //         return response()->view('errors.no-access');
    //     }

    //     $employee = Employee::with([
    //         'user',
    //         'location',
    //         'department',
    //         'role'
    //     ])->findOrFail($id);

    //     if (hasPermission('employee_view_own') && !hasPermission('employee_view_all')) {
    //         if ($employee->user_id != Auth::id()) {
    //             return response()->view('errors.no-access');
    //         }
    //     }

    //     return view('employees.show', compact('employee'));
    // }
    
    public function show($id)
{
    if (!hasPermission('employee_view_all') && !hasPermission('employee_view_own')) {
        return response()->view('errors.no-access');
    }

    $employee = Employee::with([
        'user',
        'location',
        'department',
        'role'
    ])->find($id);

    if (!$employee) {

        $user = User::find($id);

        if ($user && $user->user_type == 'admin') {
            return redirect()
                ->route('employees.index')
                ->with('error', 'This user is now ADMIN, not an employee.');
        }

        return redirect()
            ->route('employees.index')
            ->with('error', 'Employee not found.');
    }

    if (hasPermission('employee_view_own') && !hasPermission('employee_view_all')) {
        if ($employee->user_id != Auth::id()) {
            return response()->view('errors.no-access');
        }
    }
    
    $dashboards = \DB::table('employee_dashboards')
    ->join('custom_dashboards', 'employee_dashboards.dashboard_id', '=', 'custom_dashboards.id')
    ->where('employee_dashboards.employee_id', $employee->id)
    ->select('custom_dashboards.*')
    ->get();

    return view('employees.show', compact('employee','dashboards'));
}

    /*
    |-------------------------------------------------
    | EDIT
    |-------------------------------------------------
    */
    public function edit($id)
    {
        if (!hasPermission('employee_edit')) {
            return response()->view('errors.no-access');
        }

        $employee = Employee::with('user')->findOrFail($id);

        $locations   = Location::orderBy('name')->get();
        $departments = Department::orderBy('dept_name')->get();
        if (Auth::user()->role_id == 1) {
        $roles = Role::where('id', '!=', 1)
            ->where('slug', '!=', 'super-admin')
            ->orderBy('name')
            ->get();
    } else {
        $roles = Role::where('slug', 'employee')
            ->orderBy('name')
            ->get();
    }
        $customdashboards = CustomDashboard::orderBy('dash_name')->get();

        $assignedDashboards = \DB::table('employee_dashboards')
        ->where('employee_id', $employee->id)
        ->pluck('dashboard_id')
        ->toArray();

        return view(
            'employees.edit',
            compact('employee','locations','departments','roles','customdashboards','assignedDashboards')
        );
    }

    /*
    |-------------------------------------------------
    | UPDATE
    |-------------------------------------------------
    */
public function update(Request $request, $id)
{
    if (!hasPermission('employee_edit')) {
        return response()->view('errors.no-access');
    }

    $employee = Employee::findOrFail($id);
    $user = User::findOrFail($employee->user_id);

    $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
        'mobile'        => 'required|digits:10',
        'address'       => 'required|string|max:500',
        'location_id'   => 'required|exists:locations,id',
        'department_id' => 'required|exists:departments,id',
        'role_id'       => 'required|exists:roles,id',
        'gender'        => 'nullable|in:male,female,other',
        'joining_date'  => 'required|date',
        'password'      => 'nullable|string|min:6|max:50',
        'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'dashboard_ids' => 'nullable|array',
        'dashboard_ids.*' => 'exists:custom_dashboards,id',
    ]);

    /* -------------------------------------------------
     | DEPARTMENT VALIDATION
     |------------------------------------------------- */
    $department = Department::where('id', $request->department_id)
        ->where('location_id', $request->location_id)
        ->first();

    if (!$department) {
        return back()
            ->withInput()
            ->withErrors([
                'department_id' =>
                    'Selected department does not belong to selected location.'
            ]);
    }

    /* -------------------------------------------------
     | USER UPDATE
     |------------------------------------------------- */
    $user->update([
        'user_type' => 'employee',
        'name'      => $request->name,
        'role_id'   => $request->role_id,
        'email'     => $request->email,
        'mobile'    => $request->mobile,
        'address'   => $request->address,
    ]);

    /* -------------------------------------------------
     | PASSWORD UPDATE
     |------------------------------------------------- */
    if ($request->filled('password')) {
        $user->update([
            'password'      => Hash::make($request->password),
            'show_password' => $request->password,
        ]);
    }

    /* -------------------------------------------------
     | IMAGE UPLOAD
     |------------------------------------------------- */

    $imageName = $employee->image;

    if ($request->hasFile('image')) {

        $image = $request->file('image');

        /*
         * Use a controller-created directory.
         * This avoids relying on the existing employees
         * directory permissions.
         */
        $uploadDirectory = public_path('uploads/employee_images');

        if (!is_dir($uploadDirectory)) {
            @mkdir($uploadDirectory, 0777, true);
        }

        if (!is_dir($uploadDirectory)) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create employee image directory.'
                );
        }

        /*
         * Generate unique filename
         */
        $newImageName =
            'employee_' .
            time() .
            '_' .
            uniqid() .
            '.' .
            $image->getClientOriginalExtension();

        $newImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $newImageName;

        /*
         * Read uploaded temporary file
         */
        $imageContent = file_get_contents($image->getRealPath());

        if ($imageContent === false) {
            return back()
                ->withInput()
                ->with('error', 'Unable to read uploaded image.');
        }

        /*
         * Write image directly.
         * Do not use $image->move()
         */
        $written = @file_put_contents($newImagePath, $imageContent);

        if ($written === false) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to save employee image.'
                );
        }

        /*
         * Store relative path in database.
         *
         * ../employee_images/filename
         * keeps compatibility with existing Blade code:
         *
         * asset('uploads/employees/' . $employee->image)
         */
        $imageName = '../employee_images/' . $newImageName;

        /*
         * Delete old image if it belongs to the old
         * employee upload location.
         */
        if (!empty($employee->image)) {

            $oldImage = basename($employee->image);

            $oldPaths = [
                public_path('uploads/employees/' . $oldImage),
                public_path('uploads/employee_images/' . $oldImage),
            ];

            foreach ($oldPaths as $oldPath) {

                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }
    }

    /* -------------------------------------------------
     | EMPLOYEE UPDATE
     |------------------------------------------------- */
    $employee->update([
        'location_id'   => $request->location_id,
        'department_id' => $request->department_id,
        'role_id'       => $request->role_id,
        'gender'        => $request->gender,
        'joining_date'  => $request->joining_date,
        'image'         => $imageName,
    ]);

    /* -------------------------------------------------
     | CUSTOM DASHBOARD SYNC
     |------------------------------------------------- */

    \DB::table('employee_dashboards')
        ->where('employee_id', $employee->id)
        ->delete();

    if ($request->filled('dashboard_ids')) {

        $insertData = [];

        foreach ($request->dashboard_ids as $dashboardId) {

            $insertData[] = [
                'employee_id'  => $employee->id,
                'dashboard_id' => $dashboardId,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        if (!empty($insertData)) {
            \DB::table('employee_dashboards')->insert($insertData);
        }
    }

    /* -------------------------------------------------
     | ACTIVITY
     |------------------------------------------------- */
    Activity::create([
        'user_id'     => Auth::id(),
        'table_name'  => 'users',
        'table_id'    => $user->id,
        'operation'   => 'update',
        'description' => 'User "' . $user->name . '" updated as employee',
    ]);

    return redirect()
        ->route('employees.index')
        ->with('success', 'Employee updated successfully');
}

    /*
    |-------------------------------------------------
    | DELETE
    |-------------------------------------------------
    */
    public function destroy($id)
    {
        if (!hasPermission('employee_delete')) {
            return response()->view('errors.no-access');
        }

        $employee = Employee::findOrFail($id);
        $user     = User::findOrFail($employee->user_id);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'users',
            'table_id'    => $user->id,
            'operation'   => 'delete',
            'description' => 'Employee "'.$user->name.'" deleted',
        ]);

        $employee->delete();
        $user->delete();

        return redirect()
            ->route('employees.index')
            ->with('success','Employee deleted successfully');
    }

    public function getDepartments($id)
    {
        $departments = Department::where('location_id', $id)
                        ->orderBy('dept_name')
                        ->get();

        return response()->json($departments);
    }
}