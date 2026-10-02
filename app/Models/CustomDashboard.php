<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDashboard extends Model
{
    use HasFactory;

    protected $table = 'custom_dashboards';

    protected $fillable = [
        'user_id',
        'dash_name',
        'view_json',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function employees()
{
    return $this->belongsToMany(
        Employee::class,
        'employee_dashboards',
        'dashboard_id',
        'employee_id'
    );
}
}