//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 14, 2014
//UPDATE DATE: Sep 19, 2014
//REVISION: 1
//NAME: ticktab.search-flight-oneway-1.0.js
//TYPE: JavaScript / Jquery
//DESCRIPTION: Ticktab Booking Gateway
//

$(window).load(function(){
    $('ul.nav-search li a').click(function(event){
        event.preventDefault();
    });
    
    $('.checking-opt input[type="radio"]').customInput();
    $('ul.filter-search li input[type="checkbox"]').customInput();
    $('.same-cont input[type="checkbox"]').customInput();
    
    $('.search-field.flight-field .text-field.checking-opt input[type="radio"]').change(function(){
        if($('#flight-one-way').is(':checked')){
            $('.search-field.flight-field .return-date').parent().slideUp('fast');
        }else{
            $('.search-field.flight-field .return-date').parent().slideDown('fast');
        }
    });
    
    $('.date-pic').datepicker();
    
    $('.depart-result #slider-range-time').slider({
        range: true,
        min: 0,
        max: 24,
        values: [0, 24],
        slide: function(event, ui){
            if(ui.values[0].toString().length == 1) ui.values[0] = '0' + ui.values[0];
            if(ui.values[1].toString().length == 1) ui.values[1] = '0' + ui.values[1];
            
            $('.depart-result #amount-time').val(ui.values[0] + ':00 - ' + ui.values[1] + ':00');
        }
    });
    $('.depart-result #amount-time').val('0' + $('.depart-result #slider-range-time').slider('values', 0 ) + ':00 - ' + $('.depart-result #slider-range-time').slider('values', 1 ) + ':00');
    
    $('.title-nempel').click(function(event){
        event.preventDefault();
        
        var thisEl = $(this),
            thisUl = thisEl.parent().find('ul');
        
        if(thisUl.is(':visible')){
            thisUl.slideUp('fast');
            thisEl.css({'margin-bottom': '-10px', 'border-radius': '5px'});
        }else{
            thisUl.slideDown('fast');
            thisEl.css({'margin-bottom': '10px', 'border-radius': '5px 5px 0 0'});
        }
    });
    
    $('.depart-result ul.the-result-train li .pricing a').click(function(event){
        event.preventDefault();
        
        $('.depart-result').slideUp('slow',function(){
            $('.final-flow').slideDown('slow');
        });
        $('.search-flow').slideUp('slow', function(){
            $('.depart-ticket').slideDown('slow');
        });
        $('html, body').animate({ scrollTop: 0 });
    });
    
    $('.depart-ticket .button-close-tic').click(function(event){
        event.preventDefault();
        
        $('.final-flow').slideUp('slow', function(){
            $('.depart-result').slideDown('slow');
        });
        $('.depart-ticket').slideUp('slow', function(){
            $('.search-flow').slideDown('slow');
        });
        $('html, body').animate({ scrollTop: 0 });
    });
    
    $('.button-change-seat').click(function(event){
        event.preventDefault();
        
        $('.final-summary').slideUp();
        $('.change-seats').slideDown();
        $('.text-or').fadeOut();
        $(this).fadeOut();
        $('.button-close-tic').fadeOut();
    });
});