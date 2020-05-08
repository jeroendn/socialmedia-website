$(document).ready(function() {

  $('#feed .post:first-child').addClass('show');
  get_comments($('#feed .post:first-child').find('input[name="post_id"]').val());
  get_comments($('#post .post:first-child').find('input[name="post_id"]').val());

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

  // set detail posts to equal height
  $('#post .post').css('height', $('#post .post').outerWidth());

  $(window).resize(function() {
    $('#post .post').css('height', $('#post .post').outerWidth());
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

  // link post to detail page on click
  $('main:not(#feed):not(#post) .post').on('click', function () {
    window.location.href = 'post?id=' + $(this).find('input[name="post_id"]').val();
  });

  // make post clickable, but not href links
  $('.post > *:not(.message), .post > .message a').click(function(e) {
     e.stopPropagation();
  });

});
