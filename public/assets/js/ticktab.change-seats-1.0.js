//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 16, 2014
//UPDATE DATE: Sep 16, 2014
//REVISION: 1
//NAME: ticktab.change-seats-1.0.js
//TYPE: JavaScript / Jquery
//DESCRIPTION: Ticktab Booking Gateway
//

$(window).ready(function(){
    $('.change-seat-exe').click(function(event){
        event.preventDefault();
        
        if($(this).hasClass('depart-change')){
            if($('.box-change-seat-depart').is(':hidden')){
                $('.box-change-seat-depart').slideDown();
            }else{
                $('.box-change-seat-depart').slideUp();
            }
        }else if($(this).hasClass('return-change')){
            if($('.box-change-seat-return').is(':hidden')){
                $('.box-change-seat-return').slideDown();
            }else{
                $('.box-change-seat-return').slideUp();
            }
        }
    });
    
    $('.update-seat').click(function(event){
        event.preventDefault();
        
        if($(this).hasClass('update-depart')){
            $('.box-change-seat-depart').slideUp();
        }else if($(this).hasClass('update-return')){
            $('.box-change-seat-return').slideUp();
        }
    });
    
    var valPass = 7,
        numPassDepart = 1,
        numPassReturn = 1;
    
    $('.choosing-seat.depart-seat ul.the-seats li a').click(function(event){
        event.preventDefault();
        
        if(!$(this).hasClass('taken') && !$(this).hasClass('pass')){
            $('.choosing-seat.depart-seat ul.the-seats li a.pass.p' + numPassDepart).removeClass('pass').removeClass('p' + numPassDepart);
            $(this).addClass('pass').addClass('p' + numPassDepart);
            numPassDepart = numPassDepart + 1;
            
            if(numPassDepart > valPass){
                numPassDepart = 1;
            }
        }
    });
    
    $('.choosing-seat.return-seat ul.the-seats li a').click(function(event){
        event.preventDefault();
        
        if(!$(this).hasClass('taken') && !$(this).hasClass('pass')){
            $('.choosing-seat.return-seat ul.the-seats li a.pass.p' + numPassReturn).removeClass('pass').removeClass('p' + numPassReturn);
            $(this).addClass('pass').addClass('p' + numPassReturn);
            numPassReturn = numPassReturn + 1;
            
            if(numPassReturn > valPass){
                numPassReturn = 1;
            }
        }
    });
});