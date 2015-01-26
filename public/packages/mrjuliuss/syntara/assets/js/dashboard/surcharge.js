$(function() 
{
    $(document).on('submit', '#create-surcharge-form', function()
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
            if(result.surchargeCreated === false)
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
//                showStatusMessage(result.message, result.messageType);
                window.location = result.redirectUrl;
            }
        });
        return false;
    }).on('submit', '#edit-surcharge-form', function()
    {
        console.log('inside edit-surcharge-form');
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
    }).on('click', '.delete-surcharge .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            console.log('inside delete-surcharge');
            console.log(window.location.href.toString()+"/../surcharge/delete/"+$(this).data('surcharge-id'));
            $.ajax(
            {
                "url": window.location.href.toString()+"/../surcharge/delete/"+$(this).data('surcharge-id'),
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