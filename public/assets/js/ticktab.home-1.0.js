//
//Ticktab
//URL: https://www.ticktab.com
//AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
//EMAIL: nbilz@live.com
//CREATE DATE: Sep 3, 2014
//UPDATE DATE: Sep 4, 2014
//REVISION: 1
//NAME: ticktab.home-1.0.js
//TYPE: JavaScript / Jquery
//DESCRIPTION: Ticktab Booking Gateway
//

$(window).load(function(){
    $('ul.nav-search li a').click(function(event){
        event.preventDefault();
        
        var thisElem = $(this);
        
        if(!thisElem.hasClass('on-open')){
            $('ul.nav-search li a').removeClass('on-open');
            thisElem.addClass('on-open');
            
            $('.search-field').slideUp('fast');
            $('.search-field.' + (thisElem.attr('class').split(' ')[0]).split('-')[1] + '-field').slideDown('fast')
        }
    });
    
    $('.checking-opt input[type="radio"]').customInput();
    
    $('.search-field.flight-field .text-field.checking-opt input[type="radio"]').change(function(){
        if($('#flight-one-way').is(':checked')){
            $('.search-field.flight-field .return-date').parent().slideUp('fast');
        }else{
            $('.search-field.flight-field .return-date').parent().slideDown('fast');
        }
    });
    
    $('.search-field.train-field .text-field.checking-opt input[type="radio"]').change(function(){
        if($('#train-one-way').is(':checked')){
            $('.search-field.train-field .return-date').parent().slideUp('fast');
        }else{
            $('.search-field.train-field .return-date').parent().slideDown('fast');
        }
    });
    
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _renderMenu: function(ul, items) {
            var that = this, currentCategory = "";
            $.each(items, function(index, item) {
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                that._renderItemData(ul, item);
            });
        }
    });

    $(function() {
        var data = [
            {label: "anders", category: "" },
            {label: "andreas", category: "" },
            {label: "antal", category: "" },
            {label: "annhhx10", category: "Products" },
            {label: "annk K12", category: "Products" },
            {label: "annttop C13", category: "Products"},
            {label: "anders andersson", category: "People"},
            {label: "andreas andersson", category: "People"},
            {label: "andreas johnson", category: "People"}
        ];

        $(".auto-com").catcomplete({
            delay: 0,
            source: data
        });
    });
    
    $(".date-pic").datepicker();
    
    $('ul.nav-deal li a').click(function(event){
        event.preventDefault();
        
        var thisElem = $(this),
            thisType = (thisElem.attr('class').split(' ')[0]).split('-')[1];
        
        if(!thisElem.hasClass('selected')){
            $('ul.nav-deal li a').removeClass('selected');
            thisElem.addClass('selected');
            
            $('.select-list').slideUp();
            $('.' + thisType + '-select').delay('100').slideDown();
        }
    });
    
    $('.main-slider').flexslider({
        animation: "slide",
        start: function(slider) {
            $('.loading#loading-main').slideUp('fast', function() {
                adjustHeightDeal();
            });
        },
        directionNav: false
    });
    
    $(window).resize(function(){
        adjustHeightDeal();
    });
    
    function adjustHeightDeal(){
        var heightMainSlider = $('.main-slider').height();
        $('ul.deal-list').height(heightMainSlider - 53);
    }
    
    $('.switch-hotel').click(function(event){
        event.preventDefault();
        
        if(!$(this).hasClass('on-intl')){
            $(this).html('Domestic').addClass('on-intl');
            $('.domestic-hotel').slideUp();
            $('.international-hotel').slideDown();
            $('.item-tit h2').html('Recomended Hotels (International)');
        }else{
            $(this).html('International').removeClass('on-intl');
            $('.international-hotel').slideUp();
            $('.domestic-hotel').slideDown();
            $('.item-tit h2').html('Recomended Hotels (Domestic)');
        }
    });
});