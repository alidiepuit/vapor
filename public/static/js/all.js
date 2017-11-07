jQuery(document).ready(function( $ ) {
    var jump = function(e) {
        disableScroll();
        var target = location.hash;
        if (e) {
           var target = e;
        }

        $('html,body').animate({
           scrollTop: $(target).offset().top
        }, 1500, function() {
            enableScroll();
        });
    }
    // Smoth scroll on page hash links
    $('a[href*="#"]:not([href="#"])').bind('click', function(e) {
        if ($(this).attr('data-toggle')) {
            return
        }
        var target = $(this).attr('href')
        if ($(target).length > 0) {
            e.preventDefault();
            jump(target)
        } else {
            //going on href
            window.location.replace('/' + target);
        }
    });

    $('.btn-booking-service-now').click(function() {
        window.location.replace("/book-services");
    })

    if (location.hash){
        setTimeout(function(){
            $('html, body').show();
            jump();
        }, 200);
    }else{
        $('html, body').show();
    }
});