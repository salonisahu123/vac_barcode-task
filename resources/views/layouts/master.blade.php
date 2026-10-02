<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard')</title>

    <!-- ================= CSS ================= -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--multiple {
            border-radius: 8px;
            min-height: 42px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;
            border: none;
            color: #fff;
            border-radius: 5px;
            padding: 2px 8px;
        }

        /* Fix DataTables length select overlap */
        .dataTables_length select {
            width: auto !important;
            min-width: 65px;
            padding: 4px 8px !important;
            padding-right: 24px !important; /* Space for dropdown arrow */
            margin: 0 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>

    @yield('css')
</head>

<body class="dashboard dashboard_1">

<div class="full_container">
<div class="inner_container">

    <!-- SIDEBAR -->
    <x-sidebar />

    <!-- CONTENT -->
    <div id="content">

        <x-header />

        <div class="midde_cont">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <x-footer />

    </div>

</div>
</div>

<!-- ================= JS (ORDER FIXED) ================= -->

<!-- Core JS -->
<!--<script src="{{ asset('js/jquery.min.js') }}"></script>-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('js/animate.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/owl.carousel.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- ================= DATA TABLE ================= -->
<script>
window.initDataTables = function () {

    const exportRules = {
        // task: {
        //     hide: [8, 10, 11]  
        // },
        task: { 
            hide: [10]   
        },
        ticket: {
            hide: [3, 6, 7]
        },
      group: {
        hide: [4, 6]   
       },
       
       employee: {
        hide: [1, 7]   
        },
    };

    if ($.fn.DataTable.isDataTable('.datatable')) {
        $('.datatable').DataTable().destroy();
    }

    $('.datatable').each(function () {

        let tableType = $(this).data('table');
        let hideCols = exportRules[tableType]?.hide || [];

            let dtExportOptions = {
                columns: function (idx) {
                    return !hideCols.includes(idx);
                },
                format: {
                    body: function (data, row, column, node) {
                        let $node = $(node);
                        // 1. If it has a select element, return selected text
                        if ($node.find('select').length > 0) {
                            return $node.find('select option:selected').text().trim();
                        }
                        // 2. If it has an .export-data element, return its text
                        if ($node.find('.export-data').length > 0) {
                            return $node.find('.export-data').text().trim();
                        }
                        // 3. Fallback to extracting text and removing extra whitespace
                        return $node.text().replace(/\s\s+/g, ' ').trim();
                    }
                }
            };

            $(this).DataTable({
                pageLength: 10,
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                ordering: true,
                searching: true,
                responsive: true,
                lengthChange: true,
                autoWidth: false,

                dom: '<"d-flex justify-content-between align-items-center mb-2"lBf>rtip',

                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-secondary btn-sm',
                        exportOptions: dtExportOptions
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-info btn-sm',
                        exportOptions: dtExportOptions
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: dtExportOptions
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: dtExportOptions,
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 5;
                            doc.styles.tableHeader.fontSize = 5;
                            doc.pageMargins = [10, 10, 10, 10];
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length).fill('*');
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-dark btn-sm',
                        exportOptions: dtExportOptions
                    }
                ]
            });

    });

};

$(document).ready(function () {
    window.initDataTables();
});
</script>

<!-- ================= SELECT2 ================= -->
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Employees",
        width: '100%',
        closeOnSelect: false
    });
});
</script>

<!-- ================= ALERTS ================= -->
@if(session('success'))
<script>
Swal.fire({ icon:'success', title:'Success', text:"{{ session('success') }}" });
</script>
@endif

@if(session('error'))
<script>
Swal.fire({ icon:'error', title:'Error', text:"{{ session('error') }}" });
</script>
@endif

<!-- ================= DELETE CONFIRM ================= -->
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {

        e.preventDefault();

        let form = this.closest('form');

        Swal.fire({
            title: "Are you sure?",
            text: "This record will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    });
});
</script>

@yield('js')
@yield('script')

</body>
</html>