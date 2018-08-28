$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    sendRatingToServer(DOC_ID, onStar);
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 2) {
        msg = "Woo. Cảm ơn đánh giá " + ratingValue + " sao của bạn.";
    }
    else {
        msg = "Cảm ơn bạn đã đánh giá.";
    }
    responseMessage(msg);
    
  });
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
  $('.img-message').show(0, function() {
    
  });
}

function sendRatingToServer(mstl, rateRank){
  $.ajax({url: 'rate.php?mstl=' + mstl + '&rate=' + rateRank, success: function(result){
      $.ajax({url: 'rate.php?query=getInfo&mstl=' + DOC_ID,success: function(result){
        $(".chitiet span:eq(6)").html(result);
      } });
      alert(JSON.parse(result).content);
  }});
}