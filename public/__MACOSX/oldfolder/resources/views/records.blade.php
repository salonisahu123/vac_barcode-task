<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Style for separator row */
        .separator-row td {
            background-color: black;
            height: 10px;
        }
    </style>
</head>
<body>
    <h2>Packing Records</h2>
    <table>
        <thead>
            <tr>
                <th>S. No</th>
                <th>User Name</th>
                <th>WO No.</th>
                <th>Part No.</th>
                <th>SO No</th>
                <th>Line No</th>
                <th>Quantity</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @php
                $serialNumber = 1; // Initialize the serial number counter
            @endphp

            @foreach($scannedRecords as $record)
                <tr class="{{ empty($record->wo_no) && empty($record->part_no) && empty($record->so_no) ? 'separator-row' : '' }}">
                    @if (empty($record->wo_no) && empty($record->part_no) && empty($record->so_no))
                        <td colspan="8"></td> <!-- Empty separator row -->
                    @else
                        <td>{{ $serialNumber }}</td> <!-- Display serial number only for non-separator rows -->
                        <td>{{ $record->user->name ?? '' }}</td>
                        <td>{{ $record->wo_no }}</td>
                        <td>{{ $record->part_no }}</td>
                        <td>{{ $record->so_no }}</td>
                        <td>{{ $record->line_no }}</td>
                        <td>{{ $record->quantity }}</td>
                        <td>{{ $record->updated_at ?? '' }}</td>
                        @php
                            $serialNumber++; // Increment the serial number only for non-separator rows
                        @endphp
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
