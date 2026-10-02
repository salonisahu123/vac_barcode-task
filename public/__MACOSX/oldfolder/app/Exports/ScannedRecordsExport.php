<?php

namespace App\Exports;

use App\Models\History;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ScannedRecordsExport implements FromCollection, WithHeadings, WithTitle
{
    protected $woNo;
    protected $opCode;
    protected $pageNo;

    public function __construct($woNo, $opCode, $pageNo = null)
    {
        $this->woNo   = $woNo;
        $this->opCode = $opCode;
        $this->pageNo = $pageNo;
    }

    // public function collection()
    // {
    //     return History::with('user')
    //         ->where('wo_no', $this->woNo)
    //         ->where('operation_no', $this->opCode)

    //         // ✅ Apply page filter ONLY if OP_10
    //         ->when(
    //             $this->opCode === 'OP_10' && $this->pageNo,
    //             fn($query) => $query->where('page_no', $this->pageNo)
    //         )

    //         ->get()
    //         ->map(function ($record) {

    //             return [
    //                 "{$record->wo_no}~"
    //                 ."{$record->part_no}~"
    //                 ."{$record->so_no}~"
    //                 ."{$record->line_no}~"
    //                 ."{$record->operation_no}~"
    //                 ."{$record->quantity}~"
    //                 ."{$record->user_name}~"
    //                 ."{$record->page_no}"
    //             ];
    //         });
    // }
    
    public function collection()
{
    return History::with('user')
        ->where('wo_no', $this->woNo)
        ->where('operation_no', $this->opCode)

       

        // Proper sorting
        ->orderByRaw('COALESCE(page_no,0)')
        ->orderBy('so_no')
        ->orderBy('part_no')

        ->get()
        ->map(function ($record) {

            return [
                "{$record->wo_no}~"
                ."{$record->part_no}~"
                ."{$record->so_no}~"
                ."{$record->line_no}~"
                ."{$record->operation_no}~"
                ."{$record->quantity}~"
                ."{$record->user_name}"
               
            ];
        });
}

    public function headings(): array
    {
        return ['BARCODE'];
    }

    public function title(): string
    {
        return 'Sheet1';
    }
}