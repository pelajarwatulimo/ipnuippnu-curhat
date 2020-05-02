$(window).scroll(function() {    
    var scroll = $(window).scrollTop();
    if (scroll >= 50 && $('.navbar').hasClass('bg-dark') == false ) {
        $(".navbar").addClass("bg-dark");
    }
    else if(scroll < 50 && $('.navbar').hasClass('bg-dark')) {
        $(".navbar").removeClass("bg-dark");
    }
});

$(document).ready(function(){
    $('a.go-section').click(function(e){
        e.preventDefault();
    });
    $('#loading').fadeOut('slow',function(){
        $('html').removeAttr('style');
    });
});