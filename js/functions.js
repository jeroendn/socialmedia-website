function get_comments(post_id) {
  $.ajax({
    url: "php/ajax/get_comments.php",
    type: "post",
    data: { post_id:post_id }
  })
  .done((comments) => {

    let commment_count = 0;

    $('#feed .comments').children().remove();
    $.each(JSON.parse(comments), function(key, val) {
      $('#feed .comments').append('<div class="comment"><a href="profile?user=' + val.username + '"><img src="php/get_profile_icon.php?user=' + val.username + '" /></a><p class="username">' + val.username + '</p><p class="message">' + val.text + '</p></div>');
      commment_count++;
    });
    resize_comment_img();

    if (commment_count != 1) {
      $('#feed .comment-section .comment-count').text(commment_count + ' comments');
    }
    else {
      $('#feed .comment-section .comment-count').text(commment_count + ' comment');
    }

  });
};

function resize_comment_img() {
  $('#feed .comment img').css('width', $('#feed .comment img').outerHeight());
}
