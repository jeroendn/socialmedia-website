function get_comments(post_id) {
  $.ajax({
    url: "php/ajax/get_comments.php",
    type: "post",
    data: { post_id:post_id }
  })
  .done((comments) => {

    let commment_count = 0;

    $('.comment-section .comments').children().remove();
    $.each(JSON.parse(comments), function(key, val) {
      if (val.verified == true) {
        $('.comment-section .comments').append('<div class="comment"><a href="profile?user=' + val.username + '"><img src="php/get_profile_icon.php?user=' + val.username + '" /></a><p class="username">' + val.username + '<span class="verified"></span></p><p class="message">' + val.text + '</p></div>');
      }
      else {
        $('.comment-section .comments').append('<div class="comment"><a href="profile?user=' + val.username + '"><img src="php/get_profile_icon.php?user=' + val.username + '" /></a><p class="username">' + val.username + '</p><p class="message">' + val.text + '</p></div>');
      }
      commment_count++;
    });
    
    resize_comment_img();

    if (commment_count != 1) {
      $('.comment-section .comment-count').text(commment_count + ' comments');
    }
    else {
      $('.comment-section .comment-count').text(commment_count + ' comment');
    }

  });
};

function resize_comment_img() {
  $('.comment-section .comment img').css('width', $('.comment-section .comment img').outerHeight());
}
