<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>Barcode Report</title>

    <!-- DataTables + Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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
                        <h2>Barcode Table</h2>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="white_shd full margin_bottom_30">
                        <div class="full graph_head d-flex justify-content-between align-items-center">
                            <div class="heading1 margin_0">
                                <h2>Barcode Report</h2>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Upload CSV</button>
                            </div>
                        </div>

                        <form id="delete-selected-form" action="{{ route('barcode.deleteSelected') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="selected_ids" id="selected-ids">
                            <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Are you sure?')">Delete Selected</button>
                        </form>

                        <div class="table_section padding_infor_info mt-3">
                            <div class="table-responsive-sm">
                                <table id="barcodeTable" class="table display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>S. No</th>
                                            <th>WO No.</th>
                                            <th>Part No.</th>
                                            <th>SO No.</th>
                                            <th>Line No.</th>
                                            <th>Operation Code</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $index => $report)
                                        <tr>
                                            <td><input type="checkbox" name="report_ids[]" value="{{ $report->id }}" class="report-checkbox"></td>
                                             <td>{{++$index}}</td>
                                            <td>{{ $report->wo_no }}</td>
                                            <td>{{ $report->part_no }}</td>
                                            <td>{{ $report->so_no }}</td>
                                            <td>{{ $report->line_no }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" onclick="viewScannedQuantity('{{ $report->wo_no }}', '{{ $report->part_no }}', '{{ $report->line_no }}', '{{ $report->operation_code }}')">
                                                    {{ $report->operation_code }}
                                                </button>
                                            </td>
                                            <td>{{ $report->quantity }}</td>
                                            <td>
                                                <form action="{{ route('barcode.destroy', $report->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CSV Upload Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import CSV File</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="uploadForm">
                        <div class="modal-body">
                    
                            <div class="mb-3">
                                <label for="fileInput">Select CSV File</label>
                                <input type="file"
                                       class="form-control"
                                       id="fileInput"
                                       name="file"
                                       accept=".csv"
                                       required>
                                <p class="text-muted mt-2">* Upload in CSV format.</p>
                            </div>
                    
                            <div class="mb-3">
                                <label for="no_of_pages">No. of Pages</label>
                                <input type="number"
                                       class="form-control"
                                       id="no_of_pages"
                                       name="no_of_pages"
                                       min="1"
                                       placeholder="Enter number of pages"
                                       required>
                            </div>
                    
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="importBtn">
                                Import
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <x-footer />
    </div>
</div>

<!-- jQuery and DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        $('#barcodeTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copyHtml5', className: 'btn btn-secondary btn-sm' },
                { extend: 'excelHtml5', className: 'btn btn-success btn-sm' },
                { extend: 'csvHtml5', className: 'btn btn-info btn-sm' },
                { extend: 'pdfHtml5', className: 'btn btn-danger btn-sm', orientation: 'landscape' },
                { extend: 'print', className: 'btn btn-primary btn-sm' }
            ],
            paging: true,
            ordering: true,
            searching: true,
            responsive: true
        });

        $('#select-all').click(function () {
            $('.report-checkbox').prop('checked', this.checked);
        });

        $('#delete-selected-form').submit(function (e) {
            e.preventDefault();
            let selectedIds = [];
            $('.report-checkbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                $('#selected-ids').val(JSON.stringify(selectedIds));
                this.submit();
            } else {
                alert('Please select at least one report to delete.');
            }
        });

        $('#importBtn').click(function () {
            const formData = new FormData(document.getElementById('uploadForm'));
            fetch('/import-barcode', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert(data.message);
                    $('#myModal').modal('hide');
                    location.reload();
                }
            })
            .catch(err => console.error('Error:', err));
        });
    });

    function viewScannedQuantity(woNo, partNo, lineNo, operationCode) {
        fetch(`/scan-quantity?wo_no=${woNo}&part_no=${partNo}&line_no=${lineNo}&operation_code=${operationCode}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(`WO No: ${woNo}\nPart No: ${partNo}\nLine No: ${lineNo}\nOperation Code: ${operationCode}\nScanned Quantity: ${data.quantity}`);
                } else {
                    alert('No scanned quantity found.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error fetching scanned quantity.');
            });
    }
</script>
</body>
</html>
