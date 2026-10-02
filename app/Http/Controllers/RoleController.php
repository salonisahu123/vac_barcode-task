<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // 📋 LIST + FORM
    public function index()
    {
        if (hasPermission('role_view_all')) {

            $roles = Role::where('id', '!=', 1)
            ->where('slug', '!=', 'super-admin')
            ->latest()
            ->get();

        } elseif (hasPermission('role_view_own')) {

            $roles = Role::where('user_id', Auth::id())
            ->where('id', '!=', 1)
            ->where('slug', '!=', 'super-admin')
            ->latest()
            ->get();

        } else {
            return response()->view('errors.no-access');
        }

        return view('roles.index', compact('roles'));
    }

    // 💾 STORE
    public function store(Request $request)
    {
        if (!hasPermission('role_add')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create([
            'name'    => $request->name,
            'slug'    => strtolower(str_replace(' ', '-', $request->name)),
            'user_id' => Auth::id(),
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'roles',
            'table_id'    => $role->id,
            'operation'   => 'create',
            'description' => 'Role "' . $role->name . '" created',
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    // ✏ EDIT
    public function edit($id)
    {
        if (!hasPermission('role_edit')) {
            return response()->view('errors.no-access');
        }

        $roles = Role::where('id', '!=', 1)
        ->where('slug', '!=', 'super-admin')
        ->latest()
        ->get();

    $editRole = Role::where('id', '!=', 1)
        ->where('slug', '!=', 'super-admin')
        ->findOrFail($id);

        return view('roles.index', compact('roles', 'editRole'));
    }

    // 🔄 UPDATE
    public function update(Request $request, $id)
    {
        if (!hasPermission('role_edit')) {
            return response()->view('errors.no-access');
        }

        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name'    => $request->name,
            'slug'    => strtolower(str_replace(' ', '-', $request->name)),
            'user_id' => Auth::id(),
        ]);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'roles',
            'table_id'    => $role->id,
            'operation'   => 'update',
            'description' => 'Role "' . $role->name . '" updated',
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    // 🗑 DELETE
    public function destroy($id)
    {
        if (!hasPermission('role_delete')) {
            return response()->view('errors.no-access');
        }

        $role = Role::findOrFail($id);

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'roles',
            'table_id'    => $role->id,
            'operation'   => 'delete',
            'description' => 'Role "' . $role->name . '" deleted',
        ]);

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}