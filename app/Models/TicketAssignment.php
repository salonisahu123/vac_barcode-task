<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAssignment extends Model
{
    protected $fillable = [
        'ticket_id',
        'assigned_by',
        'assign_type',
        'assigned_to',
        'location_id',
        'group_id',
        'remark',
        'assigned_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'assigned_to');
    }
    
        public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
