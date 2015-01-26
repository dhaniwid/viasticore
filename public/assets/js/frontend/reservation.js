$(function() 
{
    $(document).on('submit', '#search-reservation-form', function()
    {
        var formData = new FormData($(this)[0]);
        $.ajax({
            "type": "POST",
            "url": window.location.href.toString(),
            "data": formData,
            "dataType": "json"
        }).done(function(result)
        {
            if(result.reservationResult=== false)
            {
                if(typeof result.message !== 'undefined')
                {
                    showStatusMessage(result.message, result.messageType);
                }
                else if(typeof result.errorMessages !== 'undefined')
                {
                    showRegisterFormAjaxErrors(result.errorMessages);
                }
            }
            else
            {
                window.location = result.redirectUrl;
            }
        });

        return false;
    }).on('submit', '#create-booking-form', function()
    {
        alert('stop');
        var sArray = $(this).serializeArray();
        $.ajax({
            "type": "POST",
            "url": window.location.href.toString(),
            "data": sArray,
            "dataType": "json"
        }).done(function(result)
        {
            if(result.reservationResult=== false)
            {
                if(typeof result.message !== 'undefined')
                {
                    showStatusMessage(result.message, result.messageType);
                }
                else if(typeof result.errorMessages !== 'undefined')
                {
                    showRegisterFormAjaxErrors(result.errorMessages);
                }
            }
            else
            {
                window.location = result.redirectUrl;
            }
        });

        return false;
    }).on('click', '#delete-item', function()
    {
        $('#confirm-modal').modal();
    }).on('click', '.delete-permission .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            $.ajax(
            {
                "url": window.location.href.toString()+"/../permission/"+$(this).data('permission-id'),
                "type": "DELETE"
            }).done(function(result)
            {
                showStatusMessage(result.message, result.messageType);
                ajaxContent($(this).attr('href'), ".ajax-content", false);
            });
        });

        $('#confirm-modal').modal('hide');
    })
});