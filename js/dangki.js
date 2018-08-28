/*
* @Author: ngoc trung
* @Date:   2017-10-24 21:42:15
* @Last Modified by:   ngoc trung
* @Last Modified time: 2017-10-25 00:18:38
*/

//jQuery time
// JavaScript Document
var current_fs,next_fs,previous_fs; // fields set
var left,opacity,scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
 
$('.next').click(function(){
    if(animating) return false
    animating = true;
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    //activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("#msform fieldset").index(next_fs)).addClass("active");
    next_fs.show(); //show the next fieldset
    // hide the current field set with style
    current_fs.animate({opacity:0},{
        step:function(now,fx){
            //1. scale current_fs down to 80%, now = 0 (same as opacity = 0)
            scale = 1 - (1- now)*0.2;
            //2. bring next_fs from the right(50%)
            left = (now* 50)+ "%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'transform':'scale('+scale+')'});
            next_fs.css({'left':left,'opacity':opacity});
        },
        duration:800,
        complete:function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
 
});
 
$('.previous').click(function(){
 
    if(animating) return false
    animating = true;
 
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    $('#progressbar li').eq($("#msform fieldset").index(current_fs)).removeClass("active");
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});
 
$('.submit').click(function(){
    return false;
});