<?php

use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Models\Permission;

if (!function_exists('hasPermission')) {

    function hasPermission($permissionSlug)
    {
        $user = Auth::user();

        if (!$user) return false;

        // Admin bypass
        if ($user->user_type === 'admin') {
            return true;
        }

        return RolePermission::where('role_id', $user->role_id)
            ->whereHas('permission', function ($q) use ($permissionSlug) {
                $q->where('slug', $permissionSlug);
            })
            ->exists();
    }

function hasAnyPermission(array $permissions)
{
    foreach ($permissions as $permission) {
        if (hasPermission($permission)) {
            return true;
        }
    }
    return false;
}
}