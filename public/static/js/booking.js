$.fn.extend({
    formatCurrency: function(value) {
        var val = $.isNumeric(value) ? value.toString() : value;
        if (val.length > 0) {
            this.html(parseFloat(val.replace(/,/g, ""))
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VND');
        } else {
            this.html(0);
        }
    }
});

$.fn.steps.setStep = function (step)
{
  var currentIndex = $(this).steps('getCurrentIndex');
  for(var i = 0; i < Math.abs(step - currentIndex); i++){
    if(step > currentIndex) {
      $(this).steps('next');
    }
    else{
      $(this).steps('previous');
    }
  } 
};

var increaseCurrentIndex = function() {
  var currentIndex = parseInt(Cookies.get('booking-current-index')) + 1 || 0;
  if (currentIndex < 0 || currentIndex > 3) {
    currentIndex = 0;
  }
  Cookies.set('booking-current-index', currentIndex);
}
var setCurrentIndex = function(idx) {
  Cookies.set('booking-current-index', idx);
}

var bookingSummary = {};
var dataTool = {};

var initSummary = function() {
    dataBooking = new Array();
    dataTool = new Array();
    $('input.service-detail').each(function(i, v) {
        var count = parseInt(v.value);
        var cost = parseInt($(v).data('service-cost'))
        if (count > 0) {
            var serviceId = $(v).data('service-id') || 0;
            dataBooking.push({
                'serviceTitle': $(v).data('service-title'),
                'machineTitle': $(v).data('machine-title'),
                'serviceId': $(v).data('service-id'),
                'serviceCount': count,
                'serviceTotalCost': cost*count,
                'power': $(v).data('power'),
            });
            var toolId = $(v).data('tool-id') || 0;
            if (toolId > 0) {
                dataTool.push({
                    'toolId': toolId,
                    'toolCount': count,
                });
            }
        }
    })
    if (dataBooking.length > 0) {
        $('bf-services-summary button').removeAttr('disabled');
        $('bf-services-summary .booking-panel').addClass('show');
        
        $('.booking-panel .summary').html('');
        var total = 0;
        $(dataBooking).each(function(i, val) {
            total += val.serviceTotalCost;
            var div = $('<div class="clear"/>').html('<p class="ng-scope">' + val.serviceTitle + ' - ' + val.machineTitle + ' - (' + val.power + ') - ' + val.serviceCount + ' ~ ' + val.serviceTotalCost + ' VND</p>');
            $('.booking-panel .summary').append(div);
        });
        $('span.total-cost').formatCurrency(total);
        bookingSummary.cost = total;
    } else {
        $('bf-services-summary button').attr('disabled','disabled');
        $('bf-services-summary .booking-panel').removeClass('show');
    }
}

jQuery(document).ready(function( $ ) {
    //////////////////////////
    ///      Booking      ////
    //////////////////////////
    $('.dropdown.dropdown-inline').click(function() {
        $(this).toggleClass('open');
    });


    $('.booking-flow.steps').steps({
        headerTag: "h3",
        bodyTag: "section.booking-flow-section",
        transitionEffect: "fade",
        enableAllSteps: true,
        onStepChanging: function (event, currentIndex, newIndex) {
            $('bf-booking-flow').fadeOut(300);
            return true;
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            if( currentIndex == 1) {
                if (dataBooking.length > 0) {
                    $('.order-summary .order-services li:not(:last)').remove();
                    var total = 0;
                    $(dataBooking).each(function(i, val) {
                        var li = $('<li/>').html('<span class="order-service ng-binding">' + val.serviceTitle + '</span><span class="order-price ng-binding">' + val.serviceTotalCost + '</span>');
                        $(li).insertBefore($('.order-summary .order-services li:last'));
                    });
                } else {
                    $('.order-summary').hide();
                }
            }

            //step authenticate
            if (currentIndex == 2) {
              if (USER_ID) {
                $('.booking-flow.steps').steps('next');
                setCurrentIndex(3);
                return;
              }
            }

            if (currentIndex == 3) {
                $('.appointment-summary .booking-time').html(bookingSummary.datetime);
                $('.appointment-summary .details').html($('<li/>').html('<i class="fa fa-location-arrow gs-icon" aria-hidden="true"></i>' + bookingSummary.address));
                $('.appointment-summary .prices li:not(:last)').remove();
                $(dataBooking).each(function(i, val) {
                    var li = $('<li/>').html('<span class="item order-service ng-binding">' + val.serviceTitle + ' - ' + val.machineTitle + ' - (' + val.power + ') - ' + val.serviceCount + '</span><span class="price order-price ng-binding">' + val.serviceTotalCost + '</span>');
                    $(li).insertBefore($('.appointment-summary .prices li:last'));
                });
                var li = $('<li/>').html('<span class="item order-service ng-binding"> Giảm giá </span><span class="price order-price ng-binding">' + bookingSummary.discount + '%</span>');
                $(li).insertBefore($('.appointment-summary .prices li:last'));
                $('.appointment-summary .prices li:last .price').formatCurrency(bookingSummary.cost - bookingSummary.cost*bookingSummary.discount/100);
            }
            $('bf-booking-flow').fadeIn(300);
        },
        onFinished: function (event, currentIndex) { 
            //step authenticate
            if (currentIndex == 2) {
              if (USER_ID) {
                return;
              }
            }
            $('bf-booking-flow').fadeIn(300);
        }
    }).ready(function() {
        $('bf-booking-flow').fadeIn(300).removeClass('ng-hide');
        // var currentIndex = Cookies.get('booking-current-index') || 0;
        // $(".booking-flow.steps").steps('setStep', currentIndex);
    });

    $('#booking-list-machine').tabs();

    $('.booking-next').click(function() {
        $(".booking-flow.steps").steps("next");
        increaseCurrentIndex();
    });

    jQuery('#datetimepicker').datetimepicker({
        minDate: moment().add(1, 'hour'),
    });

    $('.order-summary li.edit').click(function() {
        $(".booking-flow.steps").steps("previous");
        var currentIndex = parseInt(Cookies.get('booking-current-index')) || 0;
        Cookies.set('booking-current-index', currentIndex-1 < 0 ? 0 : currentIndex-1);
    });

    $('.number-spinner button').on('click', function (event) {
        var btn = $(this),
            oldValue = btn.closest('.number-spinner').find('input').val().trim(),
            newVal = 0;
        
        if (btn.attr('data-dir') == 'up') {
            newVal = parseInt(oldValue) + 1;
            if (newVal > 99) {
                newVal = 99;
            }
        } else {
            if (oldValue > 0) {
                newVal = parseInt(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        btn.closest('.number-spinner').find('input').val(newVal);
        btn.closest('.number-spinner').find('input').attr('data-service-count', newVal);

        initSummary();
    });

    // Advanced usage
    $("#booking-address").placepicker({
        placeChanged: function(place) {
            var location = this.getLocation()
            console.log("place changed: ", place.formatted_address, location);
            $('#booking-latitude').val(location.latitude);
            $('#booking-longitude').val(location.longitude);
        }
    });

    
    $('#booking-location').submit(function(event) {
        event.preventDefault();
        if (!$(this).valid()) {
          return;
        }
        if (!$('input[name=type_location]:checked').length) {
          $('#booking-type-location-error').show();
          $('#booking-type-location-error').html('Please select type of location');
          return;    
        } else {
          $('#booking-type-location-error').hide();
        }

        var validLocation = $(this).data('valid-location');
        if (validLocation == '1') {
            $('.booking-flow.steps').steps('next');
            setCurrentIndex(3);
            return;
        }

        var amount = 0;
        if (dataBooking.length > 0) {
            $(dataBooking).each(function(i, v) {
                amount += v.serviceCount;
            })
        }
        $('#booking-service-amount').val(amount);
        $(this).find('button[type=submit]').text('Kiểm tra ...');
        $(this).find('button[type=submit]').prop("disabled", true);

        var _this = this;
        $.ajax({
          url: '/book-services/check-valid-location',
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(data) {
            $(_this).find('button[type=submit]').removeProp("disabled");
            if (data.success) {
                $('#booking-location-error').hide();
                bookingSummary.discount = data.discount;
                if (data.discount > 0) {
                    $('#booking-discount').html('Có ' + data.amount + ' máy lạnh được đặt trong cùng khu vực, giảm thêm ' + data.discount + '%');
                }
                bookingSummary.services = dataBooking;
                bookingSummary.tools = dataTool;
                bookingSummary.address = data.address;
                bookingSummary.datetime = data.datetime;
                $(_this).find('button[type=submit]').text('Tiếp tục');
                $(_this).data('valid-location', '1');

                $('#booking-location .gs-formatted-address').hide();
                $('#booking-location .gs-address-summary').show();
                $('#booking-location .gs-address-summary .details').html($('<li/>').html(data.address))
                
            } else {
                $(_this).find('button[type=submit]').text('Done');
                $('#booking-location-error').show();
                $('#booking-location-error').html('Location is not valid.');
            }
          }
        });

    }).validate({
        rules: {
            full_address: "required",
            type_location: "required",
        },
        messages: {
            full_address: "Please enter a valid address",
            type_location: "Please select type of location",
        }
    });

    $('#booking-location-edit').click(function() {
        $('#booking-address').val('');
        $('#booking-latitude').val('');
        $('#booking-longitude').val('');
        $('#booking-location').data('valid-location', '0');
        $('#booking-location .gs-formatted-address').show();
        $('#booking-location .gs-address-summary').hide();
        $('#booking-location').find('button[type=submit]').text('Done');
        $('#booking-discount').html('');
    });

    ///////////////////////////
    //Tab remove setup VAPOR ////
    ///////////////////////////

    $('.select-grp-machine').change(function() {
        var thisVal = $(this).val();
        $('.select-grp-machine').val('---');
        $(this).val(thisVal);
        var id = $(this).val();
        var dataGrpMachine = $(this).data('grp-machine');

        $('#'+dataGrpMachine).click();

        //show/hide list power
        $('.row-power').removeClass('active');
        $('#'+id).addClass('active');
    })

    $('#service-adding-tool').on('shown.bs.modal', function() {
        $('#booking-list-service-tools').tabs();
    });

    $(".location").each(function(i, v) {
        var idInputLongitude = $(v).data('longitude');
        var idInputLatitude = $(v).data('latitude');
        $(this).placepicker({
            placeChanged: function(place) {
                var location = this.getLocation()
                console.log("place changed: ", place.formatted_address, location);
                $('#'+idInputLatitude).val(location.latitude);
                $('#'+idInputLongitude).val(location.longitude);
            }
        });
    });

    $('.row.grp-machine .column').click(function() {
        $(this).find('input[type=radio]').prop('checked', true);
    })

    ///////////////////////////
    //Tab fix VAPOR ////
    ///////////////////////////

    $('#sua-chua-khan-cap > li').click(function() {
        var val = parseInt($(this).find('input').val()) || 0;
        $(this).find('input').val(1 - val)
        initSummary();
    });

    ///////////////////////////
    //Section authenticate ////
    ///////////////////////////
    $("#section-register").hide();
    $("#section-update-info").hide();
    $("#section-login").show();
    $('.not-registered-wrap a').click(function(event) {
      event.preventDefault()
      if ($("#section-register").css('display') == 'none') {
        $("#section-register").fadeIn(300);
        $("#section-login").fadeOut(300);
      } else {
        $("#section-register").fadeOut(300);
        $("#section-login").fadeIn(300);
      }
    });

    var handleCallbackLogin = function(data) {
        if (data.success) {
            initTopMenuUserInfo();
            USER_ID = data.userId;
            if (!data.phoneNumber) {
                $.ajax({
                  url: '/user/update-info',
                  type: 'GET',
                  data: {'refresh':true},
                  success: function(html) {

                    $("#section-register").hide();
                    $("#section-update-info").html(html);
                    $("#section-update-info").show();
                    $("#section-login").hide();

                    initFormUpdateInfo(function() {
                        setCurrentIndex(3);
                        $('.booking-flow.steps').steps('next');
                    });
                  }
                });
                return
            }
            setCurrentIndex(3);
            $('.booking-flow.steps').steps('next');
        } else {
            $('div.error').html('<p class="error">'+data.error+'</p>');
        }
    }

    $('form[name="loginForm"]').on('submit', function(event) {
        event.preventDefault();
        if (!$(this).valid()) {
            return
        }
        var _this = this
        $.ajax({
          url: '/dang-nhap.html',
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(data) {
            var token = data.token
            $(_this).find('input[name="csrf_login"]').val(token);

            handleCallbackLogin(data);
          }
        });
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
        event.preventDefault();
        if (!$(this).valid()) {
            return;
        }
        var _this = this
        $.ajax({
          url: '/dang-ky.html',
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(data) {
            var token = data.token
            $(_this).find('input[name="csrf_register"]').val(token);
            
            handleCallbackLogin(data);
          }
        });
    }).validate({
        rules: {
            user_password: "required",
            user_name: {
                required: true,
                email: true
            },
            confirm_password: {
                equalTo: "#register_password",
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

    $('.book-now').click(function(event) {
        event.preventDefault();
        var _this = this;
        $(this).prop('disabled', true);
        bookingSummary.codePromotion = $('#code-promotion').val()
        $.ajax({
          url: '/book-services/book',
          type: 'post',
          dataType: 'json',
          data: bookingSummary,
          success: function(data) {
            if (data.success) {
                $(_this).hide();
                bookingSummary = new Array();
                $('.booking-flow-content.summary').fadeOut(300);
                $('.booking-flow-content.booking-success').fadeIn(300);
            } else {
                $(_this).removeProp("disabled");
            }
          }
        });
    })

    //////////////////////////
    /// Login social      ////
    //////////////////////////

    var loginSocial = function(data) {
        $.post( "/dang-nhap.html", 
            { 
                accessToken: data.accessToken, 
                userID: data.userID,
                type: data.type,
            },
            function(data) {
                handleCallbackLogin(data);
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

    $('.btnFB').click(function() {
        loginFB();
    })

    var ggCalback = function(googleUser) {
        console.log( "signedin");
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("Name: " + profile.getName());
    };

    $('.btnGG').click(function() {
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