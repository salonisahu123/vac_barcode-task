<?php
namespace App\Services;

use App\Models\Role;

class PermissionService
{
    public function syncRolePermissions($roleId, $permissions)
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->sync($permissions);
    }
}