<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Location;
use App\Models\Activity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (hasPermission('department_view_all')) {
            $departments = Department::with('location', 'user')
                ->latest()
                ->get();
        } else {
            $departments = Department::with('location', 'user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        $locations = Location::all();

        return view('departments.index', compact('departments', 'locations'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (!hasPermission('department_add')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'dept_name'   => 'required|string|max:255|unique:departments,dept_name',
            'location_id' => 'required|exists:locations,id',
        ]);

        $dept = Department::create([
            'user_id'     => Auth::id(),
            'dept_name'   => $request->dept_name,
            'location_id' => $request->location_id,
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'departments',
            'table_id'    => $dept->id,
            'operation'   => 'create',
            'description' => 'Department "' . $dept->dept_name . '" created',
        ]);

        return redirect()->back()
            ->with('success', 'Department created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        if (!hasPermission('department_edit')) {
            return response()->view('errors.no-access');
        }

        if (hasPermission('department_view_all')) {
            $departments = Department::with('location', 'user')
                ->latest()
                ->get();

            $editDepartment = Department::findOrFail($id);
        } else {
            $departments = Department::with('location', 'user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

            $editDepartment = Department::where('user_id', Auth::id())
                ->findOrFail($id);
        }

        $locations = Location::all();

        return view('departments.index', compact(
            'departments',
            'locations',
            'editDepartment'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        if (!hasPermission('department_edit')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'dept_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'dept_name')->ignore($id),
            ],
            'location_id' => 'required|exists:locations,id',
        ]);

        if (hasPermission('department_view_all')) {
            $dept = Department::findOrFail($id);
        } else {
            $dept = Department::where('user_id', Auth::id())
                ->findOrFail($id);
        }

        $dept->update([
            'dept_name'   => $request->dept_name,
            'location_id' => $request->location_id,
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'departments',
            'table_id'    => $dept->id,
            'operation'   => 'update',
            'description' => 'Department "' . $dept->dept_name . '" updated',
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (!hasPermission('department_delete')) {
            return response()->view('errors.no-access');
        }

        if (hasPermission('department_view_all')) {
            $dept = Department::findOrFail($id);
        } else {
            $dept = Department::where('user_id', Auth::id())
                ->findOrFail($id);
        }

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'departments',
            'table_id'    => $dept->id,
            'operation'   => 'delete',
            'description' => 'Department "' . $dept->dept_name . '" deleted',
        ]);

        $dept->delete();

        return redirect()->back()
            ->with('success', 'Department deleted successfully');
    }
}