<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Production Record Process</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body class="dashboard dashboard_1">
    <x-sidebar />
    <div id="content">
        <x-header />

        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h2>Packing Slip/Records</h2>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            
                <!-- Table Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                            <div class="full graph_head">
                                <div class="heading1 margin_0">
                                    <h2>Packing Slip</h2>
                                </div>
                            </div>
                            <div class="padding_infor_info">
                                <div class="mb-3 d-flex">
        <input type="text"  id="fileName" name="file_name" value="{{$fileName}}" class="form-control"aria-label="Scan Barcode" disabled>
    </div>
                                 <!-- Input for Scanning Barcode -->
    <div class="mb-3 d-flex">
        <input type="text"  id="scanInput" name="scanInput" class="form-control" placeholder="Scan Barcode Here" aria-label="Scan Barcode">
    </div>
    
      <div class="row">
        <div class="col-md-4">
            <a href="{{route('packing.slip.index')}}"><button type="submit" class="btn btn-primary">Back</button></a>
               <button type="button" class="btn btn-secondary" id="refreshButton">Refresh</button>
        </div>
    </div>
    
    <script>
    window.onload = function() {
        // Focus on the scan input field when the page loads or reloads
        const scanInput = document.getElementById('scanInput');
        if (scanInput) {
            scanInput.focus();
        }
    };
</script>
                                <!-- Button Section -->
                                <div class="mb-3 d-flex justify-content-end">
                                    <button class="btn btn-secondary me-2" id="manualEntryBtn" data-bs-toggle="modal" data-bs-target="#manualEntryModal">Manual Entry</button>
                                    <button class="btn btn-warning" id="editLastQuantityBtn">Edit Last Quantity</button>
                                </div>
 <!--<a href="{{ route('export.packingRecords') }}" class="btn btn-success me-2">Export to ERP Excel</a>-->
   <a href="{{ route('export.toPDF', ['fileName' => $fileName]) }}" class="btn btn-danger me-2">Export to PDF</a>
<a href="{{ route('export.toExcel', ['fileName' => $fileName]) }}" class="btn btn-primary">Export to Excel</a>


                                <div class="table-responsive-sm">
             <div class="mb-3 d-flex justify-content-end align-items-center" style="width: fit-content; float:right">
    <label for="searchInput" class="me-2 mb-0">Search:</label>
    <input type="text" id="searchInput" class="form-control" placeholder="Search records..." style="width: 300px;">
</div>

                                    <table class="table" id="records_table">
                                        <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>WO No.</th>
                                                <th>Part No.</th>
                                                 <th>Part No.</th>
                                                <th>SO No</th>
                                                 <th>Line No</th>
                                                <th>Quantity</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($scannedRecords as $record)
                                                <tr data-id="{{ $record->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $record->wo_no }}</td>
                                                    <td>{{ $record->part_no }}</td>
                                                      <td>{{ $record->po_no }}</td>
                                                    <td>{{ $record->so_no }}</td>
                                                     <td>{{ $record->line_no }}</td>
                                                    <td class="quantity">{{ $record->quantity }}</td>
                                                    <td>{{ $record->updated_at }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Manual Entry -->
                <div class="modal fade" id="manualEntryModal" tabindex="-1" aria-labelledby="manualEntryModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="manualEntryModalLabel">Manual Entry</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="manualEntryForm">
                                         <input type="hidden" class="form-control" id="file_name" value="{{$fileName}}" name="file_name" >
                                     <div class="mb-3">
                        <label for="modalWorkOrderNo" class="form-label">Work Order No</label>
                       
                       <input type="text" class="form-control" id="modalWorkOrderNo" name="wo_no" >
                    </div>
                  
                                    <div class="mb-3">
                                        <label for="modal_part_no" class="form-label">Part No</label>
                                        <input type="text" class="form-control" id="modal_part_no" name="part_no" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="modal_po_no" class="form-label">Po No</label>
                                        <input type="text" class="form-control" id="modal_po_no" name="po_no" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="modal_so_no" class="form-label">SO No</label>
                                        <input type="text" class="form-control" id="modal_so_no" name="so_no" required>
                                    </div>
                                  <div class="mb-3">
                                        <label for="modal_line_no" class="form-label">Line No</label>
                                        <input type="text" class="form-control" id="modal_line_no" name="line_no" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="modal_quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="modal_quantity" name="quantity" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveManualEntryBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Edit Quantity -->
                <div class="modal fade" id="editQuantityModal" tabindex="-1" aria-labelledby="editQuantityModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editQuantityModalLabel">Edit Quantity</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editQuantityForm">
                                    <div class="mb-3">
                                        <label for="edit_quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                                           <input type="hidden" id="edit_record_id" name="record_id">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="updateQuantityBtn">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-footer />
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
<script>
    $(document).ready(function() {
        // Initialize Select2 for modal Work Order No
        $('#modalWorkOrderNo').select2({
            placeholder: "Select Work Order No",
            allowClear: true
        }).next('.select2-container').addClass('form-control'); // Add form-control class

        // Initialize Select2 for modal Operation Code
        $('#modalOperationCode').select2({
            placeholder: "Select Operation Code",
            allowClear: true
        }).next('.select2-container').addClass('form-control'); // Add form-control class

        // On change of Work Order No
        $('#modalWorkOrderNo').on('change', function() {
            var woNo = $(this).val();
            if (woNo) {
                $.ajax({
                    url: "{{ route('get.operation.codes') }}",  // Route to fetch operation codes
                    type: "GET",
                    data: { wo_no: woNo },
                    success: function(data) {
                        $('#modalOperationCode').empty().append('<option value="">Select Operation Code</option>');
                        $.each(data, function(key, value) {
                            $('#modalOperationCode').append('<option value="' + value.operation_code + '">' + value.operation_code + '</option>');
                        });
                    }
                });
            } else {
                $('#modalOperationCode').empty().append('<option value="">Select Operation Code</option>');
            }
        });
    });
</script>

    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Open manual entry modal
            $('#manualEntryBtn').on('click', function() {
                $('#manualEntryForm')[0].reset(); // Clear input fields for new entry
                $('#manualEntryModal').modal('show');
            });

            // Save Manual Entry
            $('#saveManualEntryBtn').on('click', function() {
                const data = $('#manualEntryForm').serialize();
                $.ajax({
                    url: "{{ route('packing.slip.store') }}", // Your route for manual entry
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        // alert(response.success);
                        // Update the table with the new records
                        let newRows = '';
                        $.each(response.records, function(index, record) {
                            newRows += `<tr>
                                <td>${index + 1}</td>
                                <td>${record.wo_no}</td>
                                <td>${record.part_no}</td>
                                 <td>${record.po_no}</td>
                                <td>${record.so_no}</td>
                                 <td>${record.line_no}</td>
                                <td class="quantity">${record.quantity}</td>
                                <td>${record.created_at}</td>
                            </tr>`;
                        });
                        $('#records_table tbody').html(newRows);
                           location.reload(); 
                        $('#manualEntryModal').modal('hide');
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (const error in errors) {
                            errorMessage += errors[error].join(' ') + '\n';
                        }
                    alert(xhr.responseJSON.message); 
                    }
                });
            });

            // Handle edit last quantity button click
            $('#editLastQuantityBtn').on('click', function() {
                const firstRow = $('#records_table tbody tr').first(); // Get the first row
                const recordId = firstRow.data('id'); // Get the record ID
                const quantity = firstRow.find('.quantity').text(); // Get the quantity

                $('#edit_record_id').val(recordId);
                $('#edit_quantity').val(quantity);
                $('#editQuantityModal').modal('show');
            });

            // Update quantity
           // Update quantity
$('#updateQuantityBtn').on('click', function() {
    const recordId = $('#edit_record_id').val(); // Get record ID
    const quantity = $('#edit_quantity').val(); // Get quantity

    $.ajax({
        url: "{{ route('quantity.update', '') }}" + '/' + recordId, // Your route for updating quantity
        type: 'PUT',
        data: { 
            record_id: recordId, // Include record_id
            quantity: quantity 
        },
        success: function(response) {
            $('#records_table tbody tr[data-id="' + recordId + '"] .quantity').text(quantity); // Update the quantity in the table
            $('#editQuantityModal').modal('hide');
        },
        error: function(xhr) {
            const errors = xhr.responseJSON.errors;
            let errorMessage = '';
            for (const error in errors) {
                errorMessage += errors[error].join(' ') + '\n';
            }
            alert(errorMessage || xhr.responseJSON.message); 
        }
    });
});

        });
    </script>
    
<script>
    document.getElementById('scanInput').addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent default form submission
            let scannedCode = this.value;
            let fileName = document.getElementById('fileName').value; // Get the value of fileName input

            // Send AJAX request
            fetch("{{ route('scan.packingSlip') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    scanInput: scannedCode,
                    file_name: fileName // Include the file name in the request
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                        const barcodeInput = document.getElementById('barcode_input');
                    // Clear the input field and refocus it
                    this.value = ''; // Clear the input field after successful submission
                    this.focus(); // Refocus the input field to blink the cursor

                    // Optionally, you can reload the page if needed
                    location.reload();
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchValue = $(this).val().toLowerCase();
            $('#records_table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });
    });
</script>
<script>
document.getElementById('refreshButton').addEventListener('click', function() {
    location.reload(); // Refresh the page
});
</script>
</body>
</html>
