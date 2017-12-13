$(function() {
  $("time.timeago").timeago();
})
$(".clickable.facebook-sharing-button").click(function() {
  FB.ui({
        method: 'share',
        href: $(this).data('url'),
}, function(response){});
})
$(".clickable.twitter-sharing-button").click(function(event) {
  var width  = 575,
      height = 400,
      left   = ($(window).width()  - width)  / 2,
      top    = ($(window).height() - height) / 2,
      url    = $(this).data('url'),
      opts   = 'status=1' +
               ',width='  + width  +
               ',height=' + height +
               ',top='    + top    +
               ',left='   + left;
  
  window.open(url, 'twitter', opts);

  return false;
});