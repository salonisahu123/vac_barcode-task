<?php
namespace App\Exports;

use App\Models\PackingHistory; // Replace with your actual model name
use App\Models\PackingSlip; 
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings; // Import the WithHeadings interface
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelConvert implements FromCollection, WithStyles, WithHeadings, WithTitle // Implement WithHeadings
{
    /**
     * Get the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
     
     
       protected $fileName;

    // Constructor to accept the filter parameter
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }
    
    
  public function collection()
    {
        $records = PackingSlip::with('user')
            ->where('file_name', $this->fileName) // Use the passed fileName property
            ->orderBy('so_no')
            ->orderBy('part_no')
            ->get();

        $data = [];
        $previousSoNo = null;

        foreach ($records as $record) {
            if ($previousSoNo !== null && $record->so_no !== $previousSoNo) {
                // Add a blank row to act as a separator
                $data[] = [
                    'wo_no' => '', 'part_no' => '', 'po_no' => '', 'so_no' => '',
                    'line_no' => '', 'quantity' => '',
                    'user_name' => ''
                ];
            }
            $data[] = [
                'wo_no' => $record->wo_no,
                'part_no' => $record->part_no,
                'po_no' => $record->po_no,
                'so_no' => $record->so_no,
                'line_no' => $record->line_no,
                'quantity' => $record->quantity,
                'user_name' => $record->user->name,
            ];

            $previousSoNo = $record->so_no;
        }

        return collect($data);
    }


    // Method to define the headings
    public function headings(): array
    {
        return [
            'WO No', 
            'Part No',
             'Po No',
            'SO No', 
            'Line No',
            'Quantity', 
            'User Name'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Start from row 2 if row 1 has headers
        $rowCount = count($this->collection());

        for ($row = 1; $row <= $rowCount; $row++) {
            $woNo = $sheet->getCell("A{$row}")->getValue();
            if (empty($woNo)) { // Check if row is blank (you can use any column for this check)
                $sheet->getStyle("A{$row}:G{$row}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF000000'); // Black background
            }
        }
    }
    
       public function title(): string
    {
        return 'Sheet1'; // Replace with the desired title
    }
}
