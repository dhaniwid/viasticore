$(function() 
{
    $(document).on('submit', '#create-room-price-form', function()
    {
        console.log(window.location.href.toString()+"/"+$('input[name=occupancy_id]').val());
        var sArray = $(this).serializeArray();
        $.ajax({
            type: "POST",
            url: window.location.href.toString()+"/"+$('input[name=occupancy_id]').val(),
            data: sArray,
            dataType: "json"
        }).done(function(result)
        {
            console.log("test");
            if(result.roomPriceCreated === false)
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
                window.location = result.redirectUrl;
            }
        });
        return false;
    }).on('submit','#update-room-price-form',function(){
        console.log('inside edit-room-price-form');
        $form = $(this);
        var sArray = $(this).serializeArray();
        $.ajax({
            "type": "POST",
            "url": $form.attr('action'),
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
    }).on('submit', '#edit-room-price-form', function()
    {
        console.log('inside edit-room-price-form');
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
    }).on('change', '#combo-room-type', function()
    {
        var roomtype_id = $("#combo-room-type option:selected").val();
        $.ajax({
            "url": window.location.href.toString()+"/setRoomPrice/"+roomtype_id,
            "type": "POST"
        }).success(function(occupancies)
        {
            $("#table-rate").html(occupancies);
            $("#table-rate").show();
        });
    }).on('click', '#delete-item', function()
    {
        $('#confirm-modal').modal();
    }).on('click','#search-room-price-form',function(){
        console.log('inside search-room-price-form');
        $form = $(this);
        var sArray = $(this).serializeArray();
        $.ajax({
            "type": "POST",
            "url": $form.attr('action'),
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
    }).on('click', '.delete-room-price .confirm-action', function()
    {
        $.each($('.table tbody tr td input:checkbox:checked'), function( key, value ) 
        {
            $.ajax(
            {
                "url": window.location.href.toString()+"/../roomPrice/delete/"+$(this).data('room-id'),
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