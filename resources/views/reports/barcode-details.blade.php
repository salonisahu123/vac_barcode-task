<!DOCTYPE html>
<html lang="en">
   <meta name="csrf-token" content="{{ csrf_token() }}">
 <meta charset="UTF-8">
    <!-- Bootstrap CSS (Optional if not already included) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
   <body class="dashboard dashboard_1">
      <!--<div class="full_container">-->
         <!--<div class="inner_container">-->
            <!-- Sidebar  -->
            <x-sidebar />
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
             <x-header />
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                 <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Barcode Details Table</h2>
                           </div>
                        </div>
                     </div>
                     <!-- row -->
                     @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                 @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                     <div class="row">
                     
                        <!-- table section -->
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Barcode Details</h2>
                                      </div>
                              </div>
                                 <form id="delete-selected-form" action="{{ route('barcode.deleteSelected') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="selected_ids" id="selected-ids">
    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the selected reports?')">Delete Selected</button>
</form>
                              <div class="table_section padding_infor_info">
                                 <div class="table-responsive-sm">
                               <table class="table" id="barcodeTable">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th> 
                                                <th>S. No</th>
                                                <th>Part No.</th>
                                                <th>SO No.</th>
                                                <th>Line No.</th>
                                                <th>Operation Code</th>
                                                <th>Quantity required</th>
                                                <th>Scanned Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reports as $index => $report)
                                            
                                            <?php
                                              // Search for the record in the ScanBarcode table
    $scanned = DB::table('scan_brcodes')->where('wo_no',$wo_no_re)
                ->where('so_no',$report->so_no)
                 ->where('part_no',$report->part_no)
                 ->where('line_no',$report->line_no)
                 ->where('operation_no',$report->operation_code)
                ->first();
               
                                            ?>
                                            
                                            <tr>
                                                     <td><input type="checkbox" name="report_ids[]" value="{{ $report->id }}" class="report-checkbox"></td> <!-- Checkbox for each row -->
                                                  <td>{{ ++$index }}</td><!-- Serial Number -->
                                         
                                                <td>{{ $report->part_no }}</td> <!-- Part No. -->
                                                <td>{{ $report->so_no }}</td> <!-- SO No. -->
                                                <td>{{ $report->line_no }}</td> <!-- Line No. -->
                                                <td>
                                                  <button type="button" class="btn btn-info" 
                        onclick="viewScannedQuantity('{{ $report->part_no }}', '{{ $report->line_no }}', '{{ $report->operation_code }}')">
                    {{ $report->operation_code }}
                </button>
                                                </td> <!-- Operation Code -->
                                                <td>{{ $report->quantity }}</td> <!-- Quantity -->
                                                <td>{{ $scanned->quantity ?? 0}}</td>
                                                <td>
                                                   <form action="{{ route('barcode.destroy', $report->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn cur-p btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</button>
                </form>  </td>
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
            
                  <!-- footer -->
             <x-footer />
               </div>
               <!-- end dashboard inner -->
            </div>
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
 <script>
//     // Select/Deselect all checkboxes
//     document.getElementById('select-all').addEventListener('click', function() {
//         let checkboxes = document.querySelectorAll('.report-checkbox');
//         checkboxes.forEach(checkbox => checkbox.checked = this.checked);
//     });

//     // Submit the form with selected IDs
//     document.getElementById('delete-selected-form').addEventListener('submit', function(e) {
//         e.preventDefault();
        
//         let selectedIds = [];
//         let checkboxes = document.querySelectorAll('.report-checkbox:checked');

//         checkboxes.forEach(checkbox => {
//             selectedIds.push(checkbox.value);
//         });

//         if (selectedIds.length > 0) {
//             document.getElementById('selected-ids').value = JSON.stringify(selectedIds);
//             this.submit();
//         } else {
//             alert('Please select at least one report to delete.');
//         }
//     });
// </script>
// <script>
//     function viewScannedQuantity(partNo, lineNo, operationCode){
//         // Extract WO No. from the current URL
//         const urlSegments = window.location.href.split('/');
//         const woNo = urlSegments[urlSegments.length - 1]; // Get the last segment of the URL

//         // Make an AJAX request to fetch the scanned quantity
//         fetch(`/scan-quantity?wo_no=${woNo}&part_no=${partNo}&line_no=${lineNo}&operation_code=${operationCode}`)
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     // Display the scanned quantity in an alert or a modal
//                     alert(`WO No: ${woNo}\nOperation Code: ${operationCode}\nPart No: ${partNo}\nLine No: ${lineNo}\nScanned Quantity: ${data.quantity}`);
//                 } else {
//                     alert(`No scanned quantity found for the selected record.`);
//                 }
//             })
//             .catch(error => {
//                 console.error('Error fetching scanned quantity:', error);
//                 alert('An error occurred while fetching scanned quantity.');
//             });
//     }
// </script>

   </body>
</html>