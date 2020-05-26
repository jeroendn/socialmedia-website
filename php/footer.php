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
      <?php if (isset($_SESSION['username'])) { ?><a href="<?php echo 'profile?user=' . htmlspecialchars($_SESSION['username']); ?>">Profile</a><?php } else { ?>
      <a href="login">Create account</a><?php } ?>
      <a href="home">Feed</a>
      <a href="follows">Following</a>
      <a href="request-verification">Request verification</a>
      <a href="request-unban">Request unban</a>
    </div>
    <div>
      <h5>Support</h5>
      <a href="help">Help</a>
      <a href="close-account">Close account</a>
      <a href="about">About us</a>
    </div>
  </div>

  <div id="bottom-bar">
    <p class="pt-2">&copy; 2020 - <?php echo date('Y', $_SERVER['REQUEST_TIME']); ?> Posting-it | Made by: <a href="https://jeroendn.nl">jeroendn.nl</a></p>
  </div>
</footer>
