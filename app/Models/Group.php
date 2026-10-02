<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_name',
        'location_id',
        'department_id',
    ];

    // 🔗 Group created by User (Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Group has many employees (via pivot)
    public function groupEmployees()
    {
        return $this->hasMany(GroupEmployee::class);
    }

    // 🔗 Direct employees through pivot (IMPORTANT)
    // public function employees()
    // {
    //     return $this->belongsToMany(Employee::class, 'group_employees');
    // }
    
            public function employees()
        {
            return $this->belongsToMany(Employee::class, 'group_employees')
                ->wherePivotNull('removed_at')
                ->withPivot('joined_at', 'removed_at')
                ->withTimestamps();
        }

        public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}