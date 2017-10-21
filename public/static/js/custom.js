

jQuery(document).ready(function( $ ) {
    // Smoth scroll on page hash links
    $('a[href*="#"]:not([href="#"])').on('click', function() {
        if ($(this).attr('data-toggle')) {
            return
        }
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            if (target.length) {
                
                var top_space = 0;
                
                if( $('#header').length ) {
                  top_space = $('#header').outerHeight();
                }
                
                $('html, body').animate({
                    scrollTop: target.offset().top - top_space
                }, 1500, 'easeInOutExpo');
                
                return false;
            }
        }
    });

    $('form[name="loginForm"]').on('submit', function(event) {
        if (!$(this).valid()) {
            event.preventDefault();
        }
    }).validate({
        rules: {
            user_password: "required",
            user_name: {
                required: true,
                email: true
            }
        },
        messages: {
            user_name: "Please enter a valid email address",
            user_password: "Please enter a valid password",
        }
    });

    $('form[name="registerForm"]').on('submit', function(event) {
        if (!$(this).valid()) {
            event.preventDefault();
        }
    }).validate({
        rules: {
            user_password: "required",
            user_name: {
                required: true,
                email: true
            },
            confirm_password: {
                equalTo: "#password",
            },
            user_display_name: {
                required: true,
            },
            user_phone: {
                required: true,
            }
        },
        messages: {
            user_name: "Please enter a valid email address",
            confirm_password: "Please enter the same password again",
            user_display_name: "Please enter the display name",
            user_phone: "Please enter the phone number",
        }
    });

    var loginSocial = function(data) {
        $.post( "/dang-nhap.html", 
            { 
                accessToken: data.accessToken, 
                userID: data.userID,
                type: data.type,
            },
            function(data) {
                if (data.success) {
                    window.location.replace("/");
                } else {
                    $('div.error').html('<p class="error">'+data.error+'</p>');
                }
            }, "json"
        );
    }

    var loginFB = function() {
        FB.login(function(response) {
        if (response.status == "connected") {
            loginSocial({ 
                accessToken: response.authResponse.accessToken, 
                userID: response.authResponse.userID,
                type: "facebook",
            });
        }

        }, {scope: 'email,public_profile'});            
    }

    $('#btnFB').click(function() {
        loginFB();
    })

    var ggCalback = function(googleUser) {
        console.log( "signedin");
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("Name: " + profile.getName());
    };

    $('#btnGG').click(function() {
        gapi.load('auth2', function() {
            gapi.auth2.init({
                client_id: GGClientID,
                scope: "profile email" // this isn't required
            }).then(function(auth2) {
                console.log( "signed in: " + auth2.isSignedIn.get() );
                auth2.signIn().then(function(googleUser) {
                    var profile = googleUser.getBasicProfile();
                    loginSocial({ 
                        accessToken: googleUser.getAuthResponse().access_token, 
                        userID: profile.getId(),
                        type: "google",
                    });
                })
            });
        });
    })

    //////////////////////////
    /// Homebody services ////
    //////////////////////////

    $('.services-grid>li').on('click', function() {
        $('#service-content').find('.modal-body').html($(this).find('.content').html());
        $('#service-content').find('.modal-title').html($(this).find('.service-name').html());
    });

    $('#service-content').on('shown.bs.modal', function() {
        $('#service-content').focus()
    });

    
    //////////////////////////
    /// Participation ////
    //////////////////////////

    var formStep1 = $("#form-participan").show();
    $("#form-participan").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
    }).validate({
        rules: {
            fullname: "required",
            email: {
                required: true,
                email: true
            },
            repeatphone: {
                equalTo: "#phone",
            }
        },
        messages: {
            fullname: "Please enter your fullname",
            email: "Please enter a valid email address"
        }
    });

    $('#participan-next').on('click', function(event) {
        if (formStep1.valid()) {
            $("#form-participan").steps("next");
        }
    });

    $('#thamgia').on('click', function() {
        window.location.replace("/tham-gia.html");
    });

    
    //////////////////////////
    ///       User        ////
    //////////////////////////


    $('#previous-and-upcoming-control').tabs();
    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    
    

});



(function() {
 
  // store the slider in a local variable
  var $window = $(window),
      flexslider = { vars:{} };
 
  // tiny helper function to add breakpoints
  function getGridSize() {
    return (window.innerWidth < 600) ? 1 :
           (window.innerWidth < 900) ? 2 : 3;
  }
 
  $window.load(function() {
    $('.flexslider').flexslider({
      animation: "slide",
      animationLoop: false,
      itemWidth: 400,
      itemMargin: 100,
      minItems: getGridSize(), // use function to pull in initial value
      maxItems: getGridSize() // use function to pull in initial value
    });
  });
 
  // check grid size on resize event
  $window.resize(function() {
    var gridSize = getGridSize();
 
    flexslider.vars.minItems = gridSize;
    flexslider.vars.maxItems = gridSize;
  });
}());
