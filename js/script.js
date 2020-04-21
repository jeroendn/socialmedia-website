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

  // set feed posts to equal height
  $('#feed .post').css('height', $('#feed .post').outerWidth());

  $(window).resize(function() {
    $('#feed .post').css('height', $('#feed .post').outerWidth());
  });

  // set profile posts to equal height
  $('#profile .post').css('height', $('#profile .post').outerWidth());

  $(window).resize(function() {
    $('#profile .post').css('height', $('#profile .post').outerWidth());
  });

  // profile img upload
  $('#profile .profile-img .overlay').on('click', function() {
    $(this).parent().find('input[type="file"]').click();
  });

  // go to user profile on img click
  $('#follows .card img').on('click', function() {
    $(this).parent().find('a')[0].click();
  });

  // hide preload spinner
  $('#preloader').fadeOut(500);

  // delete post from user
  $('#profile button.delete').on('click', function () {
    let post_id = $(this).closest('.post').find('input[type="hidden"]').val();

    $.ajax({
      url: "php/ajax/delete_post.php",
      type: "post",
      data: { post_id:post_id }
    })
    .done(() => {
      $(this).closest('.post').fadeOut();
    });
  });

  // open write post menu
  $('#write-post').css('top', -$('#write-post').height());

  $('#open-write-post').on('click', function () {
    let elem = $(this).closest('#write-post');
    elem.toggleClass('open');

    if (elem.hasClass('open')) {
      elem.css('top', '0');
    }
    else {
      elem.css('top', -elem.height());
    }
  });

  // follow tab toggle
  $('#follows .follow-toggle').on('click', function () {
    if ($(this).parent().find('.follow-you').hasClass('active')) {
      $(this).parent().find('.follow-you').removeClass('active');
      $(this).parent().find('.you-follow').addClass('active');
      $(this).addClass('active');
    }
    else {
      $(this).parent().find('.follow-you').addClass('active');
      $(this).parent().find('.you-follow').removeClass('active');
      $(this).removeClass('active');
    }
  });

});
