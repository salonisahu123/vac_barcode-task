<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanBarcode extends Model
{
 protected $table = 'scan_brcodes';


    // Fillable properties
    protected $fillable = [
        'wo_no',
        'part_no',
        'page_no',
        'po_no',
        'so_no',
        'line_no',
        'operation_no',
        'quantity',
        'user_id'
    ];
    
        public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // 'user_id' is the foreign key in 'packing_slips' table
}
}

