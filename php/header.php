<div id="preloader"></div>

<?php if (!isset($_SESSION['user_id'])) {?>
<header id="header">
  <img class="logo" src="design/post-it_icon.png" alt="posting-it_logo">
  <p class="title mb-0">Posting-it</p>
</header>
<?php } ?>

<?php if (isset($_SESSION['user_id'])) {?>
<div id="write-post">
  <div class="container pt-2 pb-2">
    <form action="php/ajax/place_post.php" method="post">
      <textarea class="form-control" name="message" placeholder="Write a post - Max 255 characters"></textarea>
      <button class="btn btn-warning" type="submit" name="submit">Place your post</button>
    </form>
  </div>
  <span id="open-write-post"><img src="design/pin.png"></span>
</div>
<?php } ?>
