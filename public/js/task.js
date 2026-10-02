////////////////////// Create - page js ///////////////////////
$(document).ready(function(){

    $('.select2').select2({
        width:'100%'
    });

    function resetAll(){
        $('#individual_box').addClass('d-none');
        $('#location_box').addClass('d-none');
        $('#location_select_box').addClass('d-none');
        $('#location_employee_box').addClass('d-none');
        $('#group_box').addClass('d-none');
    }

    // Task Type Change
    $('#task_type').change(function(){

        resetAll();

        let type = $(this).val();

        if(type == 'individual'){
            $('#individual_box').removeClass('d-none');
        }

        if(type == 'location'){
            $('#location_box').removeClass('d-none');
        }
    });

    // Mode Change
    $('#location_mode').change(function(){

        $('#location_select_box').addClass('d-none');
        $('#location_employee_box').addClass('d-none');
        $('#group_box').addClass('d-none');

        let mode = $(this).val();

        if(mode == 'location_wise'){
            $('#location_select_box').removeClass('d-none');
        }

        if(mode == 'group_team'){
            $('#group_box').removeClass('d-none');
        }
    });

    // Location Change
    $('#location_select').change(function(){

        let locationId = $(this).val();
        let options = '';

        @foreach($employees as $emp)
            if("{{ $emp->location_id }}" == locationId){
                options += `<option value="{{ $emp->id }}">{{ $emp->user->name }}</option>`;
            }
        @endforeach

        $('#location_employees').html(options).trigger('change');

        if(locationId != ''){
            $('#location_employee_box').removeClass('d-none');
        }else{
            $('#location_employee_box').addClass('d-none');
        }

    });

    // ===== OLD VALUE RESTORE =====
    let oldTaskType = "{{ old('task_type') }}";
    let oldMode     = "{{ old('location_mode') }}";
    let oldLocation = "{{ old('location_id') }}";

    if(oldTaskType != ''){
        $('#task_type').val(oldTaskType).trigger('change');
    }

    if(oldMode != ''){
        $('#location_mode').val(oldMode).trigger('change');
    }

    if(oldLocation != ''){
        $('#location_select').val(oldLocation).trigger('change');
    }

});

///////////// edit- page js  //////////////////////////

