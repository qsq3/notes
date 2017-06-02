/**
 * 
 * @authors Your Name (iqianduan@126.com)
 * @date    2016-05-13 20:39:21
 * @version $Id$
 */
$(function(){
    (function(){
        var cart = $('.header .h_r_cart') ;
        var cartMenu = $('.header .cart_menu') ;
        cart.hover(function() {
            cart.addClass('hover');
            cartMenu.stop().slideDown();
        }, function() {
            cart.removeClass('hover');
            cartMenu.stop().slideUp();
        });
    })();
})
