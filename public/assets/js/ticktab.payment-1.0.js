//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 6, 2014
//UPDATE DATE: Sep 7, 2014
//REVISION: 1
//NAME: ticktab.payment-1.0.js
//TYPE: JavaScript / Jquery
//DESCRIPTION: Ticktab Booking Gateway
//

$(window).ready(function(){
    $('.choose-payment ul li a').click(function(event){
        event.preventDefault();
        
        if(!$(this).parent().hasClass('active')){   
            $('.choose-payment ul li').removeClass('active');
            $(this).parent().addClass('active');
            $('.choose-payment .box-check span').html($(this).attr('title'));
            
            $('.sectioning').slideUp();
            $('.section-' + $(this).attr('class').split('-')[1]).slideDown();
            
            document.getElementById('paymentType').value = document.getElementById('paymentSpan').innerHTML;
        }
    });
    
//    $('ul.form-payment li input[type="radio"]').customInput();
});