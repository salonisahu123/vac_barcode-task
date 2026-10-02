<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingHistory extends Model
{
    //
      protected $fillable = [
    'wo_no',
    'part_no',
    'po_no',
    'page_no',
    'so_no',
    'line_no',
    'user_id',
    'quantity',
    'file_name',
];

   public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // 'user_id' is the foreign key in 'packing_slips' table
}

}
