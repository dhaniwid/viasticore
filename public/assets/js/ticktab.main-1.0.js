//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 1, 2014
//UPDATE DATE: Sep 1, 2014
//REVISION: 1
//NAME: ticktab.main-1.0.js
//TYPE: JavaScript / Jquery
//DESCRIPTION: Ticktab Booking Gateway
//

$(window).load(function() {
    $('html').click(function(){
        if($('ul.setting-nav li ul').is(':visible')){
            $('ul.setting-nav li ul').slideUp('fast');
        }
    });
    
    $(".custom-select").each(function() {
        $(this).wrap("<span class='select-wrapper'></span>");
        $(this).after("<span class='holder'></span>");
    });
    $(".custom-select").change(function() {
        var selectedOption = $(this).find(":selected").text();
        $(this).next(".holder").text(selectedOption);
    }).trigger('change');
    
    $('ul.setting-nav li a').click(function(event){
        event.preventDefault();
        event.stopPropagation();
        
        if($(this).parent().find('ul').is(':visible')){
            $(this).parent().find('ul').slideUp('fast');
        }else{
            $('ul.setting-nav li ul').slideUp('fast');
            $(this).parent().find('ul').slideDown('fast');
        }
    });
    
    $('a#open-login').click(function(event){
        event.preventDefault();
        
        $('.back-white').fadeIn('fast', function(){
            $('.popup#loginin').slideDown('fast');
        });
    });
    
    $('.title-pop').on('click', 'a#go-to-forget', function(event){
        event.preventDefault();
        
        $('ul#form-login').slideUp();
        $('ul#form-forget').slideDown();
        $('.title-pop span').html('Forget Password');
        $(this).html('Login Member');
        $(this).attr('id', 'go-to-login');
    });
    
    $('.title-pop').on('click', 'a#go-to-login', function(event){
        event.preventDefault();
        
        $('ul#form-forget').slideUp();
        $('ul#form-login').slideDown();
        $('.title-pop span').html('Login Member');
        $(this).html('Forget Password');
        $(this).attr('id', 'go-to-forget');
    });
    
    $('.popup, .main-border').click(function(event){
        event.stopPropagation();
    });
    
    $('.back-white, a.close-pop, a.white-text.close-text').click(function(event){
        event.preventDefault();
        
        $('.popup').slideUp('fast', function(){
            $('.back-white').fadeOut('fast');
            if($('ul#form-forget').is(':hidden')){
                $('.popup#loginin .content-pop .title-pop span').html('Login Member');
                $('a#go-to-login').html('Forget Password');
                $('a#go-to-login').attr('id', 'go-to-forget');
                $('ul#form-forget').hide();
                $('ul#form-login').show();
            }
            
            if($('.main-border').is(':visible')){
                $('.main-border').slideUp('fast');
            }
            
            $('.popup#gall .content-pop img').hide();
            $('.popup#gall .content-pop img').attr('src', '');
            $('.popup#gall .content-pop a.gall-prev').hide();
            $('.popup#gall .content-pop a.gall-next').hide();
            $('#loading-gall').show();
            $('#loading-gall').css({'width': '0', 'height': '0'});
            $('.popup#gall').css({'marginTop': '-138px', 'marginLeft': '-128px'});
        });
    });
});