<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Production Record Process</title>


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
                            <h2>Production Record Index</h2>
                        </div>
                    </div>
                </div>

                <!-- Work Order, Operation Code, and QR Code Section -->
                <div class="p-4 mb-4 shadow border rounded" style="background-color: white;">
 <form action="{{ route('production.process') }}" method="Get">
    @csrf
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="work_order_no">Work Order No:</label>
            <select class="form-control" id="work_order_no" name="work_order_no" required>
                <option value="">Select Work Order No</option>
                @foreach($woNo as $temp)
                    <option value="{{ $temp->wo_no }}" {{ old('work_order_no') == $temp->wo_no ? 'selected' : '' }}>
                        {{ $temp->wo_no }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="operation_code">Operation Code:</label>
            <select class="form-control" id="operation_code" name="operation_code" required>
    <option value="">Select Operation Code</option>
</select>

        </div>
        <div class="col-md-4 d-none" id="pageSelectWrapper">
            <label for="page_no">Select Page</label>
            <select class="form-control" id="page_no" name="page_no">
                <option value="">Select Page</option>
            </select>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

                </div>

    

            <x-footer />
        </div>
    </div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- Custom CSS -->
<style>
    .select2-container--default .select2-selection--single {
        background-color: #fff ! important;
         border: 0px solid #aaa !important;
        border-radius: 4px ! important;
    }

</style>
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    
        const operationSelect = document.getElementById('operation_code');
        const workOrderSelect = document.getElementById('work_order_no');
        const pageWrapper = document.getElementById('pageSelectWrapper');
        const pageSelect = document.getElementById('page_no');
    
        operationSelect.addEventListener('change', function () {
    
            pageWrapper.classList.add('d-none');
            pageSelect.innerHTML = '<option value="">Select Page</option>';
    
            if (this.value === 'OP_10') {
    
                let woNo = workOrderSelect.value;
    
                if (!woNo) {
                    alert('Please select Work Order first');
                    this.value = '';
                    return;
                }
    
                fetch(`/get-no-of-pages?work_order_no=${woNo}`)
                    .then(response => response.json())
                    .then(data => {
    
                        let totalPages = parseInt(data.no_of_pages);
    
                        if (totalPages > 0) {
    
                            for (let i = 1; i <= totalPages; i++) {
                                pageSelect.innerHTML +=
                                    `<option value="${i}">Page ${i}</option>`;
                            }
    
                            pageWrapper.classList.remove('d-none');
                        }
                    });
            }
        });
    
    // });
    </script>
    <script>
        $(document).ready(function () {
        
            const pageWrapper = $('#pageSelectWrapper');
            const pageSelect  = $('#page_no');
        
            $('#operation_code').on('change', function () {
        
                let operationCode = $(this).val();
                let woNo = $('#work_order_no').val();
        
                console.log('Selected Operation Code:', operationCode);
        
                // reset page dropdown
                pageWrapper.addClass('d-none');
                pageSelect.html('<option value="">Select Page</option>');
        
                if (operationCode === 'OP_10') {
        
                    if (!woNo) {
                        alert('Please select Work Order first');
                        $(this).val('').trigger('change');
                        return;
                    }
        
                    fetch(`/get-no-of-pages?work_order_no=${woNo}`)
                        .then(res => res.json())
                        .then(data => {
        
                            let totalPages = parseInt(data.no_of_pages);
        
                            if (totalPages > 0) {
        
                                for (let i = 1; i <= totalPages; i++) {
                                    pageSelect.append(
                                        `<option value="${i}">Page ${i}</option>`
                                    );
                                }
        
                                // ✅ SHOW THE DROPDOWN
                                pageWrapper.removeClass('d-none');
                            }
                        })
                        .catch(err => console.error(err));
                }
            });
        
        });
        </script>
        
    
<script>
    $(document).ready(function() {
        // Initialize Select2 with form-control class styling
        $('#work_order_no').select2({
            placeholder: "Select Work Order No",
            allowClear: true
        }).next('.select2-container').addClass('form-control');

        $('#operation_code').select2({
            placeholder: "Select Operation Code",
            allowClear: true
        }).next('.select2-container').addClass('form-control');
    });
</script>

<script>
    $(document).ready(function() {
        $('#work_order_no').on('change', function() {
            var woNo = $(this).val();
            if (woNo) {
                $.ajax({
                    url: "{{ route('get.operation.codes') }}",  // Route to fetch operation codes
                    type: "GET",
                    data: { wo_no: woNo },
                    success: function(data) {
                        $('#operation_code').empty().append('<option value="">Select Operation Code</option>');
                        $.each(data, function(key, value) {
                            $('#operation_code').append('<option value="' + value.operation_code + '">' + value.operation_code + '</option>');
                        });
                    }
                });
            } else {
                $('#operation_code').empty().append('<option value="">Select Operation Code</option>');
            }
        });
    });
</script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

   
</body>
</html>
