function get_comments(post_id) {
  $.ajax({
    url: "php/ajax/get_comments.php",
    type: "post",
    data: { post_id:post_id }
  })
  .done((comments) => {

    $('#feed .comments').children().remove();
    $.each(JSON.parse(comments), function(key, val) {
      $('#feed .comments').append('<div class="comment"><a href="profile?user=' + val.username + '"><img src="php/get_profile_icon.php?user=' + val.username + '" /></a><p class="username">' + val.username + '</p><p class="message">' + val.text + '</p></div>');
    });
    resize_comment_img();

  });
};

function resize_comment_img() {
  $('#feed .comment img').css('width', $('#feed .comment img').outerHeight());
}
