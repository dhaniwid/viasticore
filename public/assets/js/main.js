

$(window).load(function() {    
    $( "#checkin" ).datepicker({
        dateFormat: 'dd M yy', 
        minDate: 0, 
        maxDate: "+2Y"
    });
    $( "#checkout" ).datepicker({
        dateFormat: 'dd M yy', 
        minDate: 0, 
        maxDate: "+2Y"
    });

    $("#checkin").datepicker('setDate', new Date());
    $("#checkout").datepicker('setDate', 1);
    
    $( "#datepickerin" ).datepicker({
        dateFormat: 'dd M yy', 
        minDate: 0, 
        maxDate: "+2Y"
    });
    $( "#datepickerout" ).datepicker({
        dateFormat: 'dd M yy', 
        minDate: 0, 
        maxDate: "+2Y"
    });
});