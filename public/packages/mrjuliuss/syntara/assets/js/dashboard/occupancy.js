$(function() 
{
    $(document).on('submit', '#create-occupancy-form', function()
    {
        console.log('Inside occupancy JS');
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: window.location.href.toString(),
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false
            
        }).done(function(result)
        {
            console.log('Inside function (result)');
            console.log(result);
            if(result.occupancyCreated === false)
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
    }).on('submit', '#edit-occupancy-form', function()
    {
        console.log('inside edit-occupancy-form');
        var formData = new FormData($(this)[0]);
        console.log(formData);
        $.ajax({
            type: "POST",
            url: window.location.href.toString(),
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false
        }).done(function(result)
        {
            console.log('inside function(result)');
            if(typeof result.message !== 'undefined')
            {
                console.log('inside result.message');
                showStatusMessage(result.message, result.messageType);
            }
            else if(typeof result.errorMessages !== 'undefined')
            {
                console.log('inside result.errorMessages');
                showRegisterFormAjaxErrors(result.errorMessages);
            }
        });

        return false;
    }).on('click', '#delete-item', function()
    {
        console.log('inside #delete-item');
        $('#confirm-modal').modal();
    }).on('click', '.delete-occupancies .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            console.log('inside delete-room-type');
            console.log(window.location.href.toString()+"/../occupancy/delete/"+$(this).data('occupancy-id'));
            $.ajax(
            {
                "url": window.location.href.toString()+"/../occupancy/delete/"+$(this).data('occupancy-id'),
                "type": "DELETE"
            }).done(function(result)
            {
                console.log('inside done function(result)');
                showStatusMessage(result.message, result.messageType);
                ajaxContent($(this).attr('href'), ".ajax-content", false);
            });
        });
        
        $('#confirm-modal').modal('hide');        
    });
});