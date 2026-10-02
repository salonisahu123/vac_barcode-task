
//////////////// Create page ////////////////////////
$(document).ready(function(){

    function checkTicketType()
    {
        let type = $('#ticket_type').val();

        if(type == 'location')
        {
            $('#locationBox').removeClass('d-none');
        }
        else
        {
            $('#locationBox').addClass('d-none');
            $('#location_id').val('');
        }
    }

    checkTicketType();

    $('#ticket_type').change(function(){
        checkTicketType();
    });

});



