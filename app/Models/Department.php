<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'user_id',
        'location_id',
        'dept_name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Department created by user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Department belongs to location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}