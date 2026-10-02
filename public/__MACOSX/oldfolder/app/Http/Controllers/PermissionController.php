<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $permissions = Permission::latest()->get();
        return view('permissions.index', compact('permissions'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        if (!hasPermission('permission_add')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'module' => 'required',
            'action' => 'required',
        ]);

        $permission = Permission::create([
            'name'   => ucfirst($request->module).' '.ucfirst($request->action),
            'module' => $request->module,
            'slug'   => strtolower($request->module . '_' . $request->action),
            'action' => $request->action,
            'user_id' => Auth::id()
        ]);

        Activity::create([
            'user_id'    => Auth::id(),
            'table_name' => 'permissions',
            'table_id'   => $permission->id,
            'operation'  => 'create',
            'description'=> 'Permission "'.$permission->name.'" created',
        ]);

        return redirect()->route('permissions.index')
            ->with('success','Permission created successfully');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        if (!hasPermission('permission_edit')) {
            abort(403, 'Unauthorized');
        }

        $permissions = Permission::latest()->get();
        $editPermission = Permission::findOrFail($id);

        return view('permissions.index', compact('permissions','editPermission'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        if (!hasPermission('permission_edit')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'module' => 'required',
            'action' => 'required',
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name'   => ucfirst($request->module).' '.ucfirst($request->action),
            'module' => $request->module,
            'slug'   => strtolower($request->module . '_' . $request->action),
            'action' => $request->action,
            'user_id' => Auth::id()
        ]);

        Activity::create([
            'user_id'    => Auth::id(),
            'table_name' => 'permissions',
            'table_id'   => $permission->id,
            'operation'  => 'update',
            'description'=> 'Permission "'.$permission->name.'" updated',
        ]);

        return redirect()->route('permissions.index')
            ->with('success','Permission updated successfully');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        if (!hasPermission('permission_delete')) {
            abort(403, 'Unauthorized');
        }

        $permission = Permission::findOrFail($id);

        Activity::create([
            'user_id'    => Auth::id(),
            'table_name' => 'permissions',
            'table_id'   => $permission->id,
            'operation'  => 'delete',
            'description'=> 'Permission "'.$permission->name.'" deleted',
        ]);

        $permission->delete();

        return back()->with('success','Permission deleted');
    }

    // ================= ASSIGN PAGE =================
    public function assignPage()
    {
        if (!hasPermission('role_add')) {
            abort(403, 'Unauthorized');
        }

        $roles = Role::all();
        $permissions = Permission::all()->groupBy('module');

        return view('permissions.assign', compact('roles','permissions'));
    }
}