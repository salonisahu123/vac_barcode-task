<?php

namespace App\Exports;

use App\Models\History; // Replace with your actual model name
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle; 
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelProductionConvert implements FromCollection, WithHeadings, WithEvents, WithTitle
{
    /**
     * Get the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
        protected $woNo;
    protected $opCode;
    protected $pageNo;

    public function __construct($woNo, $opCode ,$pageNo)
    {
        $this->woNo = $woNo;
        $this->opCode = $opCode;
        $this->pageNo=$pageNo;
    }
     
    public function collection()
    {
      
        // Fetch all records that need to be exported, sorted by so_no and part_no
        // $records = History::with('user')
        //     ->orderBy('so_no')   // First sort by so_no
        //     ->orderBy('part_no') // Then sort by part_no
        //     ->where('wo_no', $this->woNo)
        //   ->where('operation_no', $this->opCode)
        //     ->get();
    //     $records = History::with('user')
    // ->orderBy('so_no')
    // ->orderBy('part_no')
    // ->where('wo_no', $this->woNo)
    // ->where('operation_no', $this->opCode)

    // ✅ Apply page filter only if OP_10
    // ->when(
    //     $this->opCode === 'OP_10' && $this->pageNo,
    //     fn($query) => $query->where('page_no', $this->pageNo)
    // )

    // ->get();
    
    $records = History::with('user')
    ->where('wo_no', $this->woNo)
    ->where('operation_no', $this->opCode)
    ->orderBy('page_no', 'asc')   // FIRST sort by page number
    ->orderBy('so_no', 'asc')
    ->orderBy('part_no', 'asc')
    ->get();

        $data = [];
        $previousSoNo = null;

        foreach ($records as $record) {
            if ($previousSoNo !== null && $record->page_no !== $previousSoNo) {
                // Add a blank row to act as a separator
                $data[] = [
                    'wo_no' => '', 'part_no' => '', 'po_no' => '',  'so_no' => '',
                    'line_no' => '', 'operation_no' => '', 'quantity' => '',
                    'user_name' => '' ,'page_no'=>'',
                ];
            }
            $data[] = [
                'wo_no' => $record->wo_no,
                'part_no' => $record->part_no,
                'po_no' => $record->po_no,
                'so_no' => $record->so_no,
                'line_no' => $record->line_no,
                'operation_no' => $record->operation_no,
                'quantity' => $record->quantity,
                'user_name' => $record->user->name,
                'page_no' => $record->page_no,
            ];

            $previousSoNo = $record->page_no;
        }

        return collect($data);
    }

    /**
     * Define the header row.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'WO No',
            'Part No',
            'Po No',
            'SO No',
            'Line No',
            'Operation No',
            'Quantity',
            'User Name',
             'Page No'
        ];
    }

    /**
     * Register the events for the export.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();
                $highestRow = $worksheet->getHighestRow();

                // Loop through each row to find blank rows and apply black background color
                for ($row = 2; $row <= $highestRow; $row++) { // Start from row 2 if row 1 is the header
                    $wo_no = $worksheet->getCell("A{$row}")->getValue();
                    $part_no = $worksheet->getCell("B{$row}")->getValue();
                    $so_no = $worksheet->getCell("C{$row}")->getValue();

                    // Check if the row is a blank separator (empty cells)
                    if (empty($wo_no) && empty($part_no) && empty($so_no)) {
                        $worksheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FF000000'); // Black color
                    }
                }
            },
        ];
    }
    
    public function title(): string
    {
        return 'Sheet1'; // Replace with the desired title
    }
    
    
}
