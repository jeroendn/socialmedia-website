<div id="preloader"></div>

<?php if (!isset($_SESSION['user_id'])) {?>
<header id="header">

</header>
<?php } ?>

<?php if (isset($_SESSION['user_id'])) {?>
<div id="write-post">
  <div class="container pt-2 pb-2">
    <form action="index.html" method="post">
      <textarea class="form-control" name="message" placeholder="Write a post"></textarea>
      <button class="btn btn-warning" type="submit" name="submit">Place post</button>
    </form>
  </div>
  <span id="open-write-post"><img src="design/pin.png"></span>
</div>
<?php } ?>
