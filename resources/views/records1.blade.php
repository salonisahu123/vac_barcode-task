<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%; /* Set table width to 100% */
            border-collapse: collapse;
            font-size: 12px; /* Reduce font size for better PDF fit */
            table-layout: fixed; /* Fixed layout to control width distribution */
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            word-wrap: break-word; /* Enable word wrapping */
        }

        th {
            background-color: #f2f2f2;
        }

        .separator-row {
            background-color: black;
        }

        /* Print-specific styles */
        @media print {
            table {
                width: 100%;
                font-size: 10px; /* Smaller font for PDF generation */
            }

            th, td {
                padding: 4px; /* Reduce padding for print */
            }
        }
    </style>
</head>
<body>
    <h2>Scanned Records</h2>
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>User Name</th>
                <th>WO No.</th>
                <th>Part No.</th>
                <th>Po No.</th>
                <th>SO No</th>
                <th>Line No</th>
                <th>Operation No</th>
                <th>Quantity</th>
                <th>Timestamp</th>
                <th>Page No</th>
            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = 1;
            @endphp

            @foreach($scannedRecords as $record)
                <tr class="{{ empty($record->wo_no) && empty($record->part_no) && empty($record->so_no) ? 'separator-row' : '' }}">
                    @if (empty($record->wo_no) && empty($record->part_no) && empty($record->so_no))
                        <td colspan="10"></td>
                    @else
                        <td>{{ $serialNumber }}</td>
                        <td>{{ $record->user->name ?? '' }}</td>
                        <td>{{ $record->wo_no ?? '' }}</td>
                        <td>{{ $record->part_no ?? '' }}</td>
                        <td>{{ $record->po_no ?? '' }}</td>
                        <td>{{ $record->so_no ?? '' }}</td>
                        <td>{{ $record->line_no ?? '' }}</td>
                        <td>{{ $record->operation_no ?? '' }}</td>
                        <td>{{ $record->quantity ?? '' }}</td>
                        <td>{{ $record->updated_at ?? '' }}</td>
                        <td>{{ $record->page_no ?? '' }}</td>
                        @php
                            $serialNumber++;
                        @endphp
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
