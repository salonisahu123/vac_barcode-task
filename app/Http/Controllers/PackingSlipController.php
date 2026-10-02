<?php
// PackingSlipController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\PackingSlip; // Make sure you import your model
use App\Models\BarcodeDetail;
use App\Models\PackingHistory;
use Illuminate\Http\Request;

class PackingSlipController extends Controller
{
    // Method to handle storing packing slip data
public function store(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'wo_no' => 'required|string|max:255',
        'part_no' => 'required|string|max:255',
        'po_no' => 'required|string|max:255',
        'so_no' => 'required|string|max:255',
        'line_no' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Check if a packing slip record with the same details already exists
    $packingSlip = PackingSlip::where([
        'wo_no' => $request->wo_no,
        'part_no' => $request->part_no,
        'so_no' => $request->so_no,
        'line_no' => $request->line_no,
    ])->first();

    if ($packingSlip) {
        // If it exists, update the quantity
        $packingSlip->quantity += $request->quantity;
        $packingSlip->save();

        // Check for an existing history record for the current user
        $packingHistory = PackingHistory::where([
            'wo_no' => $request->wo_no,
            'part_no' => $request->part_no,
            'so_no' => $request->so_no,
            'line_no' => $request->line_no,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($packingHistory) {
            // If a history record exists for the same user, update the quantity
            $packingHistory->quantity += $request->quantity;
            $packingHistory->save();
        } else {
            // If no history exists for the current user, create a new record
            PackingHistory::create([
                'wo_no' => $request->wo_no,
                'part_no' => $request->part_no,
                'po_no' => $request->po_no,
                'so_no' => $request->so_no,
                'line_no' => $request->line_no,
                'quantity' => $request->quantity,
                'file_name' => $request->file_name,
                'user_id' => Auth::user()->id,
                'user_name' =>Auth::user()->name,
            ]);
        }

        return response()->json(['success' => 'Packing slip updated successfully!', 'packingSlip' => $packingSlip], 200);
    } else {
        // If it doesn't exist, create a new packing slip record
        $packingSlip = PackingSlip::create([
            'wo_no' => $request->wo_no,
            'part_no' => $request->part_no,
            'po_no' => $request->po_no,
            'so_no' => $request->so_no,
            'line_no' => $request->line_no,
            'quantity' => $request->quantity,
            'file_name' => $request->file_name,
            'user_id' => Auth::user()->id,
            'user_name' =>Auth::user()->name,
        ]);

        // Create a new history record
        PackingHistory::create([
            'wo_no' => $request->wo_no,
            'part_no' => $request->part_no,
            'po_no' => $request->po_no,
            'so_no' => $request->so_no,
            'line_no' => $request->line_no,
            'quantity' => $request->quantity,
              'file_name' => $request->file_name,
            'user_id' => Auth::user()->id,
            'user_name' =>Auth::user()->name,
        ]);

        return response()->json(['success' => 'Packing slip created successfully!', 'packingSlip' => $packingSlip], 201);
    }
}


 // Method to handle updating the quantity of a packing slip
    public function updateQuantity(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1', // Ensure quantity is a positive integer
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Find the packing slip by ID
        $packingSlip = PackingSlip::find($id);
$updatedQuntity = $request->quantity - $packingSlip->quantity;
        // Check if the packing slip exists
        if (!$packingSlip) {
            return response()->json(['error' => 'Packing slip not found.'], 404);
        }
        
         $existingScansCount = PackingSlip::where('wo_no', $packingSlip->wo_no)
        ->where('part_no', $packingSlip->part_no)
        ->where('line_no', $packingSlip->line_no)
        ->sum('quantity');

    $totalQuantityAfterUpdate = $existingScansCount - $packingSlip->quantity + $request->quantity;

    // if ($totalQuantityAfterUpdate > $barcodeDetail->quantity) {
    //     return response()->json(['success' => false, 'message' => 'Updated quantity exceeds available quantity in barcode details.']);
    // }

        // Update the quantity
        $packingSlip->quantity = $request->quantity;
        $packingSlip->save();
        
          $packingHistory = PackingHistory::where([
            'wo_no' => $packingSlip->wo_no,
            'part_no' => $packingSlip->part_no,
            'line_no' => $packingSlip->line_no,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($packingHistory) {
            // If the same user updates, increment the quantity
            
            
            $packingHistory->quantity += $updatedQuntity;
            $packingHistory->save();
        }else{
               PackingHistory::create([
            'wo_no' => $packingSlip->wo_no,
            'part_no' => $packingSlip->part_no,
            'po_no' => $packingSlip->po_no,
            'so_no' => $packingSlip->so_no,
            'line_no' => $packingSlip->line_no,
            'quantity' => $updatedQuntity,
		'file_name' => $request->file_name,
            'user_id' => Auth::user()->id,
            'user_name' =>Auth::user()->name,
        ]);
        }

        // Return a success response
        return response()->json(['success' => 'Packing slip quantity updated successfully!', 'packingSlip' => $packingSlip], 200);
    }
     
    
  public function scanPackingSlip(Request $request)
{
    
    // Validate the incoming request
    $request->validate([
        'scanInput' => 'required|string|max:255',
    ]);

    // Extract data from the scanned barcode string using the ~ separator
    $scannedData = explode('~', $request->scanInput);

    if (count($scannedData) < 4) {
        return response()->json(['error' => 'Invalid scanned data format.'], 400);
    }

    // Assign the extracted values to their corresponding fields
    $woNo = $scannedData[0];
    $partNo = $scannedData[1];
    $poNo = $scannedData[2];
    $soNo = $scannedData[3];
    $lineNo = $scannedData[4];
    $file_name= $request->file_name;

    // Check if a record with the same details already exists
    $packingSlip = PackingSlip::where([
        'wo_no' => $woNo,
        'part_no' => $partNo,
        'so_no' => $soNo,
        'line_no' => $lineNo,
        'file_name' =>$file_name,
        
    ])->first();

    if ($packingSlip) {
        // If it exists, increment the quantity
        $packingSlip->quantity += 1;
        $packingSlip->save();
           // Check for an existing PackingHistory for the same user
        $packingHistory = PackingHistory::where([
            'wo_no' => $woNo,
            'part_no' => $partNo,
            'so_no' => $soNo,
            'line_no' => $lineNo,
            'file_name'=>$file_name,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($packingHistory) {
            // If the same user updates, increment the quantity
            $packingHistory->quantity += 1;
            $packingHistory->save();
        } else {
            // If a different user updates, create a new PackingHistory entry
            PackingHistory::create([
                'wo_no' => $woNo,
                'part_no' => $partNo,
                'po_no' => $poNo,
                'so_no' => $soNo,
                'line_no' => $lineNo,
                'file_name' => $request->file_name,
                'user_id' => Auth::user()->id,
                'user_name' =>Auth::user()->name,
                'quantity' => 1,
            ]);
        }
    } else {
        // If it doesn't exist, create a new record
        PackingSlip::create([
            'wo_no' => $woNo,
            'part_no' => $partNo,
            'po_no' => $poNo,
            'so_no' => $soNo,
            'line_no' => $lineNo,
            'file_name' => $request->file_name,
             'user_id' =>Auth::user()->id,
             'user_name' =>Auth::user()->name,
            'quantity' => 1, // Starting quantity for a new scan entry
        ]);
        
            PackingHistory::create([
                'wo_no' => $woNo,
            'part_no' => $partNo,
            'po_no' => $poNo,
            'so_no' => $soNo,
            'line_no' => $lineNo,
            'file_name' => $request->file_name,
             'user_id' =>Auth::user()->id,
             'user_name' =>Auth::user()->name,
            'quantity' => 1, // Starting quantity for a new scan entry
        ]);
    }

    // Fetch all records to return as JSON
    $scannedRecords = PackingSlip::all();

    return response()->json([
        'success' => 'Record processed successfully!',
        'records' => $scannedRecords,
    ]);
}

    
    
    
}
