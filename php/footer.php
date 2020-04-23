<?php if (isset($_SESSION['user_id'])) {?>
<footer id="footer">
  <nav id="main-menu" class="container">
    <li class="menu-item"><a href="<?php
    echo 'profile?user=' . htmlspecialchars($_SESSION['username']);
    ?>" class="fas fa-user"></a></li>
    <li class="menu-item"><a href="home" class="fas fa-home"></a></li>
    <li class="menu-item"><a href="follows" class="fas fa-users"></a></li>
  </nav>
</footer>
<?php } ?>

<footer id="secondary-footer" class="mt-5">
  <div class="footer-wrap container pt-3 pb-3">
    <div>
      <h5>Account</h5>
      <?php if (isset($_SESSION['username'])) { ?><a href="<?php echo 'profile?user=' . htmlspecialchars($_SESSION['username']); ?>">profile</a><?php } else { ?>
      <a href="login">Create account</a><?php } ?>
      <a href="home">feed</a>
      <a href="follows">following</a>
    </div>
    <div>
      <h5>Support</h5>
      <a href="help">help</a>
      <a href="#!">Close account</a>
      <a href="#!">About us</a>
    </div>
  </div>

  <div id="bottom-bar">
    <p>Posting-it&copy; 2020</p>
  </div>
</footer>
