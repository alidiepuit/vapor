jQuery(document).ready(function( $ ) {
    // Smoth scroll on page hash links
    $('a[href*="#"]:not([href="#"])').on('click', function() {
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

    var loginSocial = function(data) {
        $.post( "/authenticate/login", 
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


    
});

