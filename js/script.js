$(document).ready(function() {

  // login submit
  $('#login-form').submit(function(e) {
    var request;
    e.preventDefault();

    if (request) {
      request.abort();
    }

    var form = $(this);
    var inputs = form.find("input, select, button, textarea");
    var serializedData = form.serialize();

    inputs.prop("disabled", true);

    request = $.ajax({
      url: "php/ajax/login_submit.php",
      type: "post",
      data: serializedData
    });

    request.done(function () {
      window.location.href = 'home';
    });

    request.fail((error) => {
      $(this).find('.alert').remove();
      $(this).prepend('<div class="alert alert-warning">' + error.statusText + '!</div>')
    });

    request.always(function () {
      inputs.prop("disabled", false);
    });
  });

  // register submit
  $('#register-form').submit(function(e) {
    var request;
    e.preventDefault();

    if (request) {
      request.abort();
    }

    var form = $(this);
    var inputs = form.find("input, select, button, textarea");
    var serializedData = form.serialize();

    inputs.prop("disabled", true);

    request = $.ajax({
      url: "php/ajax/register_submit.php",
      type: "post",
      data: serializedData
    });

    request.done(function () {
      window.location.href = 'home';
    });

    request.fail((error) => {
      $(this).find('.alert').remove();
      $(this).prepend('<div class="alert alert-warning">' + error.statusText + '!</div>')
    });

    request.always(function () {
      inputs.prop("disabled", false);
    });
  });

  $('#profile .profile-img img').css('max-height', $('#profile .profile-img img').outerWidth()).css('height', $('#profile .profile-img img').outerWidth());

  $(window).resize(function() {
    $('#profile .profile-img img').css('max-height', $('#profile .profile-img img').outerWidth()).css('height', $('#profile .profile-img img').outerWidth());
  });

  // follow a user
  $('button.btn-follow').on('click', function () {
    let username = $(this).attr('user');

    $.ajax({
      url: "php/ajax/follow_submit.php",
      type: "post",
      data: { username:username }
    })
    .done(() => {
      $(this).removeClass('active');
      $(this).parent().find('.btn-unfollow').addClass('active');
    });
  });

  // unfollow a user
  $('button.btn-unfollow').on('click', function () {
    let username = $(this).attr('user');

    $.ajax({
      url: "php/ajax/unfollow_submit.php",
      type: "post",
      data: { username:username }
    })
    .done(() => {
      $(this).removeClass('active');
      $(this).parent().find('.btn-follow').addClass('active');
    });
  });

  // profile img upload
  $('#profile .profile-img .overlay').on('click', function() {
    $(this).parent().find('input[type="file"]').click();
  });

  // go to user profile on img click
  $('#follows .card img').on('click', function() {
    $(this).parent().find('a')[0].click();
  });

  // follows profile img 1x1 sizing
  $('#follows .card img').css('height', $('#follows .card img').outerWidth());

  // hide preload spinner
  $('#preloader').fadeOut(500);

  // set post img to equal height
  $('#feed .post').css('height', $('#feed .post').outerWidth());

  $(window).resize(function() {
    $('#feed .post').css('height', $('#feed .post').outerWidth());
  });

});
