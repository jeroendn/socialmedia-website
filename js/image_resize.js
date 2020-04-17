$(document).ready(function() {

  // profile img resize
  $('#profile .profile-img img').css('max-height', $('#profile .profile-img img').outerWidth()).css('height', $('#profile .profile-img img').outerWidth());

  $(window).resize(function() {
    $('#profile .profile-img img').css('max-height', $('#profile .profile-img img').outerWidth()).css('height', $('#profile .profile-img img').outerWidth());
  });

  // follows profile img 1x1 sizing
  $('#follows .card img').css('height', $('#follows .card img').outerWidth());

  // feed imgae resize
  $('#feed .post img').css('height', $('#feed .post img').outerWidth());

  $(window).resize(function() {
    $('#feed .post img').css('height', $('#feed .post img').outerWidth());
  });

});
