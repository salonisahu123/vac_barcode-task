<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarcodeDetail extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'si_no', 'wo_no', 'part_no', 'so_no', 'line_no', 
        'operation_code', 'quantity','barcode_path','no_of_pages'];
}
