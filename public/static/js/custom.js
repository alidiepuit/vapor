var initNumberInput = function(ele) {
    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter(ele + ' input');
    jQuery(ele).each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val() || min);
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val() || min);
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });
        
        $(this).attr('data-init', 'done');
    });
}


var dataBooking = [];
var initSummary = function() {
    if (dataBooking.length > 0) {
        $('bf-services-summary button').removeAttr('disabled');
        $('bf-services-summary .booking-panel').addClass('show');
        
        $('.booking-panel .summary').html('');
        $(dataBooking).each(function(i, val) {
            var total = 0;
            $(val.data).each(function(i, val) {
                total += val.cost;
            })
            var div = $('<div class="clear"/>').html('<p>' + val.service + ' - ' + val.title + ' - ' + total + '</p>');
            $('.booking-panel .summary').append(div);
        });
    } else {
        $('bf-services-summary button').attr('disabled','disabled');
        $('bf-services-summary .booking-panel').removeClass('show');
    }
}

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

    
    //////////////////////////
    ///      Booking      ////
    //////////////////////////
    
    $('.booking-flow.steps').steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        onStepChanged: function (event, currentIndex, priorIndex) {
            if( currentIndex == 1) {
                if (dataBooking.length > 0) {
                    $('.order-summary .order-services li:not(:last)').remove();
                    var total = 0;
                    $(dataBooking).each(function(i, val) {
                        var costEachService = 0;
                        $(val.data).each(function(i, val) {
                            costEachService += val.cost;
                        })
                        total += costEachService;
                        var li = $('<li/>').html('<span class="order-service ng-binding">' + val.service + '</span><span class="order-price ng-binding">' + costEachService + '</span>');
                        $(li).insertBefore($('.order-summary .order-services li:last'));
                    });
                } else {
                    $('.order-summary').hide();
                }
            }
        }
    });

    $('#booking-list-machine').tabs();

    $('#booking-machine').on('shown.bs.modal', function() {
        $('#booking-machine').focus()
    });

    $('.booking-services li').on('click', function() {
        $('#booking-machine').find('.modal-title').html($(this).attr('data-title'));
        $('#booking-form').attr('data-service',$(this).attr('data-service'));
    });

    $('#booking-add-row').click(function() {
        $('#booking-table tbody').append($('#booking-temp-table tbody').html())
        initNumberInput('#booking-table tbody tr td div.quantity[data-init="none"]');
    });
    
    $('#booking-accept').click(function() {
        if ($('#booking-form').valid()) {
            var title = $('#booking-title').text();
            var service = $('#booking-form').attr('data-service');
            var obj = [];
            $('#booking-table tbody tr').each(function(i, val) {
                var power = parseInt($(val).find('select.booking').val());
                var amount = parseInt($(val).find('input.amount').val());
                var cost = parseInt($(val).find('p.cost').text());
                obj.push({
                    "power": power,
                    "amount": amount,
                    "cost": cost,
                })
            });
            if (obj.length > 0) {
                dataBooking.push({
                                title: title,
                                service: service,
                                data: obj,
                            })
                $('#booking-table tbody').html('')
                initSummary();
            }
            $('#booking-machine').modal('hide')
        }
    })

    $('#booking-next').click(function() {
        $(".booking-flow.steps").steps("next");
    });

    jQuery('#datetimepicker').datetimepicker({
        allowTimes:[
          '12:00', '13:00', '15:00', 
          '17:00', '17:05', '17:20', '19:00', '20:00'
         ]
    });

    $('.order-summary li.edit').click(function() {
        $(".booking-flow.steps").steps("previous");
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
