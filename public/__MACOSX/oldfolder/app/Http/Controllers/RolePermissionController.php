<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends Controller
{
    public function index()
    {
        if (hasPermission('role_permission_view_all')) {

            $roles = Role::where('slug', '!=', 'super-admin')->get();

        } elseif (hasPermission('role_permission_view_own')) {

            $roles = Role::where('user_id', Auth::id())
                    ->where('slug', '!=', 'super-admin')
                    ->get();
            

        } else {
            return response()->view('errors.no-access');
        }

        return view('role_and_permission.index', compact('roles'));
    }

    public function create()
    {
        if (!hasPermission('role_permission_add')) {
            return response()->view('errors.no-access');
        }

        $roles = Role::where('slug', '!=', 'super-admin')->get();
        $permissions = Permission::all()->groupBy('module');

        return view('role_and_permission.assign', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        if (!hasPermission('role_permission_add')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'role_id' => 'required'
        ]);

        $roleId = $request->role_id;
        $role = Role::find($roleId);

        $existing = RolePermission::where('role_id', $roleId)
                    ->pluck('permission_id')
                    ->toArray();

        $new = $request->permissions ?? [];

        $toInsert = array_diff($new, $existing);

        if (!empty($toInsert)) {

            $data = [];

            foreach ($toInsert as $pid) {
                $data[] = [
                    'role_id'       => $roleId,
                    'permission_id' => $pid,
                    'user_id'       => Auth::id(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            RolePermission::insert($data);
        }

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'role_permissions',
            'table_id'    => $roleId,
            'operation'   => 'assign',
            'description' => 'Permissions updated for role "' . $role->name . '"',
        ]);

        return redirect()->route('roles_permissions.index')
            ->with('success', 'Permissions updated');
    }

    public function show($roleId)
    {
        if (!hasPermission('role_permission_view_all') && !hasPermission('role_permission_view_own')) {
            return response()->view('errors.no-access');
        }

        $role = Role::findOrFail($roleId);

        if (hasPermission('role_permission_view_own') && !hasPermission('role_permission_view_all')) {
            if ($role->user_id != Auth::id()) {
                return response()->view('errors.no-access');
            }
        }

        $permissions = Permission::all()->groupBy('module');

        $assigned = RolePermission::where('role_id', $roleId)
                    ->pluck('permission_id')
                    ->toArray();

        return view('role_and_permission.view', compact('role', 'permissions', 'assigned'));
    }

    public function edit($roleId)
    {
        if (!hasPermission('role_permission_edit')) {
            return response()->view('errors.no-access');
        }

        $role = Role::findOrFail($roleId);
        $roles = Role::where('slug', '!=', 'super-admin')->get();

        $permissions = Permission::all()->groupBy('module');

        $assigned = RolePermission::where('role_id', $roleId)
                    ->pluck('permission_id')
                    ->toArray();

        return view('role_and_permission.edit', compact(
            'role', 'roles', 'permissions', 'assigned'
        ));
    }

    public function update(Request $request, $roleId)
    {
        if (!hasPermission('role_permission_edit')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'role_id' => 'required',
        ]);

        $newRoleId = $request->role_id;

        if ($roleId != $newRoleId) {
            RolePermission::where('role_id', $roleId)->delete();
        }

        $existingPermissions = RolePermission::where('role_id', $newRoleId)
                                ->pluck('permission_id')
                                ->toArray();

        $newPermissions = $request->permissions ?? [];

        $permissionsToInsert = array_diff($newPermissions, $existingPermissions);

        if (!empty($permissionsToInsert)) {

            $insertData = [];

            foreach ($permissionsToInsert as $permissionId) {
                $insertData[] = [
                    'role_id'       => $newRoleId,
                    'permission_id' => $permissionId,
                    'user_id'       => Auth::id(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            RolePermission::insert($insertData);
        }

        RolePermission::where('role_id', $newRoleId)
            ->whereNotIn('permission_id', $newPermissions)
            ->delete();

        $role = Role::find($newRoleId);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'role_permissions',
            'table_id'    => $newRoleId,
            'operation'   => 'update',
            'description' => 'Permissions updated for role "' . $role->name . '"',
        ]);

        return redirect()->route('roles_permissions.index')
            ->with('success', 'Permissions updated successfully');
    }

    public function destroy($roleId)
    {
        if (!hasPermission('role_permission_delete')) {
            return response()->view('errors.no-access');
        }

        $role = Role::findOrFail($roleId);

        RolePermission::where('role_id', $roleId)->delete();

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'role_permissions',
            'table_id'    => $roleId,
            'operation'   => 'delete',
            'description' => 'All permissions removed from role "' . $role->name . '"',
        ]);

        return back()->with('success', 'Permissions removed successfully');
    }
}