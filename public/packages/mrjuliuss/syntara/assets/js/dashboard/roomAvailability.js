$(function() 
{
    $(document).on('submit', '#create-room-availability-form', function()
    {
        console.log(window.location.href.toString());
        var sArray = $(this).serializeArray();
        $.ajax({
            type: "POST",
            url: window.location.href.toString(),
            data: sArray,
            dataType: "json"
        }).done(function(result)
        {
            if(result.roomAvailabilityCreated === false)
            {
                if(typeof result.message !== 'undefined')
                {
                    console.log('inside result.message !== undefined');
                    showStatusMessage(result.message, result.messageType);
                }
                else if(typeof result.errorMessages !== 'undefined')
                {
                    console.log('inside result.errorMessage !== undefined');
                    showRegisterFormAjaxErrors(result.errorMessages);
                }
            }
            else
            {
                showStatusMessage(result.message, result.messageType);
                //window.location = result.redirectUrl;
            }
        });
        return false;
    }).on('click', '#view-button', function()
    {
        var sArray = $(this).serializeArray();
        var startDate = $("#datepicker_from").val();
        var endDate = $("#datepicker_to").val();
        $.ajax({
            "url": window.location.href.toString()+"/setRoomAvailability/"+startDate+"/"+endDate,
            "type": "GET",
            data: sArray,
            dataType: "text"
        }).success(function(roomAvailabilities)
        {
            $("#table-availability").html(roomAvailabilities);
            $("#table-availability").show();
        });
        return false;
    }).on('click', '#delete-item', function()
    {
        $('#confirm-modal').modal();
    }).on('click', '.delete-room-availability .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            $.ajax(
            {
                "url": window.location.href.toString()+"/../roomAvailability/delete/"+$(this).data('room-id'),
                "type": "DELETE"
            }).done(function(result)
            {
                console.log('inside done function(result)');
                showStatusMessage(result.message, result.messageType);
                ajaxContent($(this).attr('href'), ".ajax-content", false);
            });
        });
        
        $('#confirm-modal').modal('hide');        
    })
});