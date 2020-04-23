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

  $('#feed .post:not(:last-child)').draggable(
    {
    axis: 'x',
    start: function(e, ui) {
      this.previousPosition = ui.position;
    },
    stop: function(e, ui) {
      $(this).css('left','0');
      var distance = ui.position.left - this.previousPosition.left;
      let like_or_seen = 'seen';

      if (distance > 100) {
        like_or_seen = 'like';
      }
      else if (distance < -100) {
        like_or_seen = 'seen';
      }

      let post_id = $(this).find('input[type="hidden"]').val();
      let next_post_id = $(this).next().find('input[type="hidden"]').val();

      $.ajax({
        url: "php/ajax/" + like_or_seen + "_post.php",
        type: "post",
        data: { post_id:post_id }
      })
      .done(() => {
        $(this).removeClass('show');
        $(this).next().addClass('show');
        if (next_post_id !== undefined) {
          get_comments(next_post_id);
        }
        else {
          $('#feed .comments').children().remove();
        }
      });

    }
  });

});
