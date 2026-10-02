<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = [
    'wo_no',
    'part_no',
    'page_no',
    'po_no',
    'so_no',
    'line_no',
    'operation_no',
    'user_id',
    'quantity',
    'user_name',
];


   public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // 'user_id' is the foreign key in 'packing_slips' table
}

}
