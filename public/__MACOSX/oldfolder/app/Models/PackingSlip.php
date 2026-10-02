<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingSlip extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'packing_slips';

    // Define the fillable properties for mass assignment
    protected $fillable = [
        'wo_no',
        'part_no',
        'page_no',
        'po_no',
        'so_no',
        'line_no',
        'quantity',
        'file_name',
        'user_id',
    ];

    // Optionally, if you want to use timestamps (created_at and updated_at)
    public $timestamps = true;
    
    public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // 'user_id' is the foreign key in 'packing_slips' table
}
}
