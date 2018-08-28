/*
* @Author: ngoc trung
* @Date:   2017-11-07 17:26:53
* @Last Modified by:   ngoc trung
* @Last Modified time: 2017-11-07 20:05:54
*/

var CAU_HOI;
$(function(){
	$('#start').click(function(){
		$('#thithu').show(0, function() {
			
		});
        if ($('#lua-chon').val() == '0') {
            alert('Bạn cần lựa chọn môn học để bắt đầu!');
        }else{
    		$('#thithu > h1').html('Đề thi thử môn ' + $('#lua-chon option:selected').text());
            if ($('#log-sign').is(':visible')) {
                alert('Bạn cần đăng nhập trước để sử dụng chức năng này!');
                location.reload();
            }else{
                $('#lest-go').hide();
                $.ajax({url: 'get-question.php?mon=' + $('#lua-chon').val(), success: function(result){
                    CAU_HOI = JSON.parse(result);
                    console.log(result);
                    for (var i = 0; i < CAU_HOI.length; i++) {
                        $('#quest-area').append(
                            '<div class="col-xs-12 que">' + 
                            '<p><b style="color: #33CCCC;font-size: 20px;margin-right: 10px">Câu '+ (i+1) +':</b><span class="max">'+ CAU_HOI[i].cauhoi +'</span></p>' +
                            '<span class="col-xs-12 col-md-6"><input type="radio" value="A" style="margin-right: 10px" name="'+ (i+1) +'"></input>'+
                            '<span class="max da">A.'+ CAU_HOI[i].dapana +'</span></span> '+
                            '<span class="col-xs-12 col-md-6"><input type="radio" value="B" style="margin-right: 10px" name="'+ (i+1) +'"></input>'+
                            '<span class="max da">B.'+ CAU_HOI[i].dapanb +'</span></span>'+
                            '<span class="col-xs-12 col-md-6" style="clear:left;"><input type="radio" value="C" style="margin-right: 10px" name="'+ (i+1) +'"></input>'+
                            '<span class="max da">C.'+ CAU_HOI[i].dapanc +'</span></span>'+
                            '<span class="col-xs-12 col-md-6"><input type="radio" value="D" style="margin-right: 10px" name="'+ (i+1) +'"></input>'+
                            '<span class="max da">D.'+ CAU_HOI[i].dapand +'</span></span>'+
                            '</div>'
                        );
                    }
                    var latex2math = $('.max');
                    for (var i = 0; i < latex2math.length; i++) {
                         MathJax.Hub.Queue(["Typeset",MathJax.Hub,latex2math[i]]);
                    }
                    //alert('Ngu');
                }});
            }
        }
	});

});

$(function(){
     $('#end').click(function(){
        $('#bangdiem').show(0, function() {
            //alert("Nộp bài thành công");
            $("html, body").animate({ scrollTop: 0 }, "slow");
            var socaudung = 0;
            for (var i = 0; i < 50; i++) {
               if($('input[name='+ (i+1) +']:checked').val() == CAU_HOI[i].dapandung){
                socaudung++;
               }
               $('input[name="'+ (i+1) +'"][value="'+(CAU_HOI[i].dapandung)+'"]').next().css('color', 'red');
            }
            $('#bangdiem td:nth-child(3)').html(socaudung);
            $('#bangdiem td:nth-child(4)').html(50 - socaudung);
            $('#bangdiem td:nth-child(5)').html(socaudung/5);
            //alert(socaudung);
        });
        $('#end').hide(0, function() {
            
        });
        $('#txt').hide(0, function() {
            
        });
    });
});
$(function(){
	var Countdown = {
  
  // Backbone-like structure
  $el: $('.countdown'),
  
  // Params
  countdown_interval: null,
  total_seconds     : 0,
  
  // Initialize the countdown  
  init: function() {
    
    // DOM
		this.$ = {
    	hours  : this.$el.find('.bloc-time.hours .figure'),
    	minutes: this.$el.find('.bloc-time.min .figure'),
    	seconds: this.$el.find('.bloc-time.sec .figure')
   	};

    // Init countdown values
    this.values = {
	      hours  : this.$.hours.parent().attr('data-init-value'),
        minutes: this.$.minutes.parent().attr('data-init-value'),
        seconds: this.$.seconds.parent().attr('data-init-value'),
    };
    
    // Initialize total seconds
    this.total_seconds = this.values.hours * 60 * 60 + (this.values.minutes * 60) + this.values.seconds;

    // Animate countdown to the end 
    this.count();    
  },
  
  count: function() {
    
    var that    = this,
        $hour_1 = this.$.hours.eq(0),
        $hour_2 = this.$.hours.eq(1),
        $min_1  = this.$.minutes.eq(0),
        $min_2  = this.$.minutes.eq(1),
        $sec_1  = this.$.seconds.eq(0),
        $sec_2  = this.$.seconds.eq(1);
    
        this.countdown_interval = setInterval(function() {

        if(that.total_seconds > 0) {

            --that.values.seconds;              

            if(that.values.minutes >= 0 && that.values.seconds < 0) {

                that.values.seconds = 59;
                --that.values.minutes;
            }

            if(that.values.hours >= 0 && that.values.minutes < 0) {

                that.values.minutes = 59;
                --that.values.hours;
            }

            // Update DOM values
            // Hours
            that.checkHour(that.values.hours, $hour_1, $hour_2);

            // Minutes
            that.checkHour(that.values.minutes, $min_1, $min_2);

            // Seconds
            that.checkHour(that.values.seconds, $sec_1, $sec_2);

            --that.total_seconds;
        }
        else {
            clearInterval(that.countdown_interval);
        }
    }, 1000);    
  },
  
  animateFigure: function($el, value) {
    
     var that         = this,
		     $top         = $el.find('.top'),
         $bottom      = $el.find('.bottom'),
         $back_top    = $el.find('.top-back'),
         $back_bottom = $el.find('.bottom-back');

    // Before we begin, change the back value
    $back_top.find('span').html(value);

    // Also change the back bottom value
    $back_bottom.find('span').html(value);

    // Then animate
    TweenMax.to($top, 0.8, {
        rotationX           : '-180deg',
        transformPerspective: 300,
	      ease                : Quart.easeOut,
        onComplete          : function() {

            $top.html(value);

            $bottom.html(value);

            TweenMax.set($top, { rotationX: 0 });
        }
    });

    TweenMax.to($back_top, 0.8, { 
        rotationX           : 0,
        transformPerspective: 300,
	      ease                : Quart.easeOut, 
        clearProps          : 'all' 
    });    
  },
  
  checkHour: function(value, $el_1, $el_2) {
    
    var val_1       = value.toString().charAt(0),
        val_2       = value.toString().charAt(1),
        fig_1_value = $el_1.find('.top').html(),
        fig_2_value = $el_2.find('.top').html();

    if(value >= 10) {

        // Animate only if the figure has changed
        if(fig_1_value !== val_1) this.animateFigure($el_1, val_1);
        if(fig_2_value !== val_2) this.animateFigure($el_2, val_2);
    }
    else {

        // If we are under 10, replace first figure with 0
        if(fig_1_value !== '0') this.animateFigure($el_1, 0);
        if(fig_2_value !== val_1) this.animateFigure($el_2, val_1);
    }    
  }
};

// Let's go !
Countdown.init();
	})

