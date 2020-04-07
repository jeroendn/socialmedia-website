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
      $(this).prepend('<div class="alert alert-warning">' + error.statusText + '</div>')
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
      url: "php/ajax/register.php",
      type: "post",
      data: serializedData
    });

    request.done(function () {
      window.location.href = 'home';
    });

    request.fail((error) => {
      $(this).find('.alert').remove();
      $(this).prepend('<div class="alert alert-warning">' + error.statusText + '</div>')
    });

    request.always(function () {
      inputs.prop("disabled", false);
    });
  });

});
