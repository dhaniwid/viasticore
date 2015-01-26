//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 13, 2014
//UPDATE DATE: Sep 13, 2014
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
    
    $('.depart-result #slider-range-price').slider({
        range: true,
        min: 50000,
        max: 50000000,
        values: [50000, 50000000],
        slide: function(event, ui){
            $('.depart-result #amount-price').val('IDR ' + ui.values[ 0 ].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1.') + ' - ' + ui.values[ 1 ].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1.'));
        }
    });
    $('.depart-result #amount-price').val('IDR ' + $('.depart-result #slider-range-price').slider('values', 0) +  ' - ' + $('.depart-result #slider-range-price').slider('values', 1));
    
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
    
    var buttonInctive = false;
    
    function cursorNavDepart(){
        if($('.depart-result .scheduling ul li.before-last').is(':visible')){
            $('.depart-result .scheduling a.nav-sche.prev-sche').fadeOut('fast');
        }else{
            $('.depart-result .scheduling a.nav-sche.prev-sche').fadeIn('fast');
        }

        if($('.depart-result .scheduling ul li.after-last').is(':visible')){
            $('.depart-result .scheduling a.nav-sche.next-sche').fadeOut('fast');
        }else{
            $('.depart-result .scheduling a.nav-sche.next-sche').fadeIn('fast');
        }
    }
    
    $('.depart-result .scheduling a.nav-sche').click(function(event){
        event.preventDefault();
        
        if(buttonInctive == false){
            buttonInctive = true;
            
            var thisSelecting = $('.depart-result .scheduling ul li.showing.selecting');
            $('.depart-result .scheduling ul li.showing').removeClass('selecting');

            if($(this).hasClass('prev-sche')){
                $('.depart-result .scheduling ul li.showing').last().animate({'width': 'toggle'}).removeClass('showing').addClass('hide-after');
                $('.depart-result .scheduling ul li.hide-before').last().animate({'width': 'toggle'}, function(){
                    buttonInctive = false;
                    cursorNavDepart();
                }).removeClass('hide-before').addClass('showing');
                thisSelecting.prev().addClass('selecting');
            }else{
                $('.depart-result .scheduling ul li.showing').first().animate({'width': 'toggle'}).removeClass('showing').addClass('hide-before');
                $('.depart-result .scheduling ul li.hide-after').first().animate({'width': 'toggle'}, function(){
                    buttonInctive = false;
                    cursorNavDepart();
                }).removeClass('hide-after').addClass('showing');
                thisSelecting.next().addClass('selecting');
            }
        }
    });
    
    $('.depart-result ul.the-result li .pricing a').click(function(event){
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
    
//    $('.scheduling ul').on('click', ' li.showing a', function(event){
//        event.preventDefault();
//        
//        var thisIndex = $('.scheduling ul li.showing').index($(this).parent());
//        
//        if(!$(this).parent().hasClass('selecting')){
//            if(thisIndex >= 0 && thisIndex <= 2){
//                alert('Before');
//            }else if(thisIndex >= 4 && thisIndex <= 6){
//                alert('After');
//            }
//        }
//    });
});