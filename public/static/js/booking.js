$.fn.extend({
    formatCurrency: function(value) {
        var val = $.isNumeric(value) ? value.toString() : value;
        this.html(parseFloat(val.replace(/,/g, ""))
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VND');
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

var dataBooking = new Array();
var initSummary = function() {
    dataBooking = new Array();
    $('input.service-detail').each(function(i, v) {
        var count = parseInt(v.value);
        var cost = parseInt($(v).data('service-cost'))
        if (count > 0) {
            dataBooking.push({
                'serviceTitle': $(v).data('service-title'),
                'machineTitle': $(v).data('machine-title'),
                'serviceId': $(v).data('service-id'),
                'serviceCount': count,
                'serviceTotalCost': cost*count,
                'power': $(v).data('power'),
            });
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
            $('span.total-cost').formatCurrency(total);
        });
    } else {
        $('bf-services-summary button').attr('disabled','disabled');
        $('bf-services-summary .booking-panel').removeClass('show');
    }
}

jQuery(document).ready(function( $ ) {
    //////////////////////////
    ///      Booking      ////
    //////////////////////////
    
    $('.booking-flow.steps').steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
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
            Cookies.set('booking-current-index', currentIndex);
        }
    }).ready(function() {
        var currentIndex = Cookies.get('booking-current-index') || 0;
        $(".booking-flow.steps").steps('setStep', currentIndex);
    });

    $('#booking-list-machine').tabs();

    $('.booking-next').click(function() {
        $(".booking-flow.steps").steps("next");
    });

    jQuery('#datetimepicker').datetimepicker({
        minDate: moment().add(1, 'hour'),
    });

    $('.order-summary li.edit').click(function() {
        $(".booking-flow.steps").steps("previous");
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
    // $("#booking-address").placepicker({
    //     placeChanged: function(place) {
    //         var location = this.getLocation()
    //         console.log("place changed: ", place.formatted_address, location);
    //         $('#booking-latitude').val(location.latitude);
    //         $('#booking-longitude').val(location.longitude);
    //     }
    // });

    //Section 3: Authentication
    $('.booking-flow-authentication .booking-flow-content').steps({
        headerTag: "h3",
        bodyTag: "div.page-container",
    });

    $('.not-registered-wrap a').click(function(event) {
      event.preventDefault()
      $('.booking-flow-authentication .booking-flow-content').steps('setStep', 1 - $(this).data('step'))
    });

    $('form[name="loginForm"]').on('submit', function(event) {
        event.preventDefault();
        if (!$(this).valid()) {
            return
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
        event.preventDefault();
        if (!$(this).valid()) {
            return;
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
});