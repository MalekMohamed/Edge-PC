
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
    $('#stars li').on('click', function(){
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        var msg = "";
        $.ajax({
            type: 'post',
            url: base_url + "?request=rate",
            data: {value: ratingValue , item : $('.rating-stars').data('item')},
            success: function (res) {
                var resp = $.parseJSON(res);
                if (resp.status == 'success') {
                    if (ratingValue > 1) {
                        msg = "Thanks! You rated this " + ratingValue + " stars.";
                    } else {
                        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                    }
                    responseMessage(msg);
                } else {
                    $.Notification.autoHideNotify('error',"bottom left","Response",resp.msg);
                }
            }
        });


    });


});


function responseMessage(msg) {
   console.log(msg);
    $.Notification.autoHideNotify('success',"bottom left","Response",msg);
}