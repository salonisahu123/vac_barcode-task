<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'permission_id',
        'user_id',
    ];

    // 🔗 belongs to Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // 🔗 belongs to Permission
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}