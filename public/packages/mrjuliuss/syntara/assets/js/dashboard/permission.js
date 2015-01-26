$(function() 
{
    $(document).on('submit', '#create-permission-form', function()
    {
        var sArray = $(this).serializeArray();
        console.log(sArray);
        $.ajax({
            "type": "POST",
            "url": window.location.href.toString(),
            "data": sArray,
            "dataType": "json"
        }).done(function(result)
        {
            console.log('inside done(function(result))');
            if(result.permissionCreated === false)
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
    }).on('submit', '#edit-permission-form', function()
    {
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
        $('#confirm-modal').modal();
    }).on('click', '.delete-permission .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            console.log(window.location.href.toString());
            $.ajax(
            {
                "url": window.location.href.toString()+"/../permission/"+$(this).data('permission-id'),
                "type": "DELETE"
            }).done(function(result)
            {
                console.log('inside done function(result)');
                showStatusMessage(result.message, result.messageType);
                console.log($(this).attr('href'));
                ajaxContent($(this).attr('href'), ".ajax-content", false);
            });
        });

        $('#confirm-modal').modal('hide');
    })
});