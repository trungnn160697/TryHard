/*
* @Author: ngoc trung
* @Date:   2017-10-21 22:31:44
* @Last Modified by:   ngoc trung
* @Last Modified time: 2017-10-21 22:47:28
*/
$(function() {
    var pull = $('#pull');
        menu = $('.menu ul');
        menuHeight = menu.height();
 
    $(pull).on('click', function(e) {
        e.preventDefault();
        menu.slideToggle();
    });
});
$(window).resize(function(){
    var w = $(window).width();
    if(w > 320 && menu.is(':hidden')) {
        menu.removeAttr('style');
    }
});
