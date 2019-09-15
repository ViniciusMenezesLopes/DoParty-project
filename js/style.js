$(document).ready(function(){
    // Função scroll
    $(window).scroll(function(){
        if($(this).scrollTop() >= 80)
        {
            $('[data-container="menu"]').addClass('menu-fixed');
        }
        if($(this).scrollTop() < 10)
        {
            $('[data-container="menu"]').removeClass('menu-fixed');
        }
    });
});