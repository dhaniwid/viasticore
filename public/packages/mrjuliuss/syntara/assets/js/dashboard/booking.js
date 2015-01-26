$(function() 
{
    $(document).on('submit', '#create-booking-form', function()
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
            if(result.bookingCreated === false)
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
    }).on('submit', '#edit-booking-form', function()
    {
        console.log('inside edit-booking-form');
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
    });
});