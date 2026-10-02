<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'employee_id',
        'joined_at',
        'removed_at',
    ];
    
    protected $casts = [
    'joined_at' => 'date',
    'removed_at' => 'date',
    ];

    // 🔗 belongs to Group
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // 🔗 belongs to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}