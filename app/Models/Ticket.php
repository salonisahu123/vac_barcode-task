<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'ticket_type',
        'location_id',
        'department_id',
        'subject',
        'priority',
        'attachment',
        'description',
        'status',
        'assigned_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function assignments()
    {
        return $this->hasMany(TicketAssignment::class);
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

        public function department()
    {
        return $this->belongsTo(Department::class);
    }
    
        public function location()
    {
        return $this->belongsTo(Location::class);
    }
}


