<?php
namespace App\Exports;

use App\Models\PackingHistory; // Replace with your actual model name
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PackingRecordsExport implements FromCollection, WithTitle
{
    /**
     * Get the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch all records that need to be exported
        return PackingHistory::with('user')->get()->map(function ($record) {
            // Concatenate the required columns into a single column
            return [
                "{$record->wo_no}~{$record->part_no}~{$record->so_no}~{$record->line_no}~{$record->quantity}~{$record->user_name}"
            ];
        });
    }

    /**
     * Define the header row.
     *
     * @return array
     */
      public function title(): string
    {
        return 'Sheet1'; // Replace with the desired title
    }
}
