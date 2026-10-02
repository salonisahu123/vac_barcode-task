<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'department_id',
        'role_id',
        'gender',
        'joining_date',
        'image',
    ];

    // 🔗 Employee belongs to User (login account)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Employee belongs to Location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // 🔗 Employee belongs to Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

        public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_employees')
            ->wherePivotNull('removed_at')
            ->withPivot('joined_at', 'removed_at')
            ->withTimestamps();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function dashboards()
{
    return $this->belongsToMany(
        CustomDashboard::class,
        'employee_dashboards',
        'employee_id',
        'dashboard_id'
    );
}
}