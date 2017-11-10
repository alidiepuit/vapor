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

    
    $('.thamgia').on('click', function() {
        function goToRegisterVapor(){
            window.location.replace("/tham-gia.html");
        };
        window.setTimeout(goToRegisterVapor, 500); 
    });

    var callbackUpdateInfoSuccess = function() {
        window.location.replace("/user");
    }

    initFormUpdateInfo(callbackUpdateInfoSuccess);
});

var initTopMenuUserInfo = function() {
    $.ajax({
      url: '/user/topmenu',
      type: 'GET',
      data: $(this).serialize(),
      success: function(html) {
        $('#topmenu-user-info').html(html);
        initScriptTopMenuUserInfo();
      }
    });
};

var initScriptTopMenuUserInfo = function() {
    $('.dropdown.dropdown-inline').click(function() {
        $(this).toggleClass('open');
    });
}

var initFormUpdateInfo = function(callbackUpdateInfoSuccess) {
    $('form[name="updateInfoForm"]').on('submit', function(event) {
        event.preventDefault();
        if (!$(this).valid()) {
            return
        }
        var _this = this
        $.ajax({
          url: '/user/update-info',
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(data) {
            var token = data.token
            $(_this).find('input[name="csrf_update_info"]').val(token);
            if (data.success) {
                callbackUpdateInfoSuccess();
                return;
            } else {
                $(_this).find('div.error').html('<p class="error">'+data.error+'</p>');
            }
          }
        });
    }).validate({
        rules: {
            update_form_username: "required",
            update_form_display_name: "required",
            update_form_phone_number: "required",
        },
    });
};