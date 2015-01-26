$(function() 
{
    $(document).on('submit', '#upload-image-form', function()
    {
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
            if(result.uploadedImage === false)
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
    }).on('submit', '#edit-room-form', function()
    {
        console.log('inside edit-room-form');
        var sArray = $(this).serializeArray();
        $.ajax({
            "type": "PUT",
            "url": window.location.href.toString(),
            "data": sArray,
            "dataType": "json"
        }).done(function(result)
        {
            if(typeof result.message !== 'undefined')
            {
                showStatusMessage(result.message, result.messageType);
            }
            else if(typeof result.errorMessages !== 'undefined')
            {
                showRegisterFormAjaxErrors(result.errorMessages);
            }
        });

        return false;
    }).on('click', '#delete-item', function()
    {
        console.log('inside #delete-item');
        $('#confirm-modal').modal();
    }).on('click', '.delete-room-type .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            console.log('inside delete-room-type');
            console.log(window.location.href.toString()+"/../roomType/delete/"+$(this).data('room-id'));
            $.ajax(
            {
                "url": window.location.href.toString()+"/../roomType/delete/"+$(this).data('room-id'),
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