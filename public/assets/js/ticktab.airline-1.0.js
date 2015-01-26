//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 5, 2014
//UPDATE DATE: Sep 6, 2014
//REVISION: 1
//NAME: ticktab.airline-1.0.js
//TYPE: JavaScript / Jquery
//DESCRIPTION: Ticktab Booking Gateway
//

$(window).load(function(){
    $('.bungkus-putih .text-field.checking-opt input[type="radio"]').change(function(){
        if($('#flight-one-way').is(':checked')){
            $('.returning-input').parent().slideUp('fast');
        }else{
            $('.returning-input').parent().slideDown('fast');
        }
    });
    
    $('.checking-opt input[type="radio"]').customInput();
    
    $(".date-pic").datepicker();
});