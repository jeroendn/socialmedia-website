<?php if (isset($_SESSION['user_id'])) {?>
<footer id="footer">
  <nav id="main-menu" class="container">
    <li class="menu-item"><a href="<?php
    echo 'profile?user=' . $_SESSION['username'];
    ?>" class="fas fa-user"></a></li>
    <li class="menu-item"><a href="home" class="fas fa-home"></a></li>
    <li class="menu-item"><a href="follows" class="fas fa-users"></a></li>
  </nav>
</footer>
<?php } ?>

<footer id="secondary-footer"></footer>
