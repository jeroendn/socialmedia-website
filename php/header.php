<header id="header">
  <div class="header-logo">
    <a href="home">Social Media</a>
  </div>

  <nav id="nav-wrapper">
    <ul id="main-menu" class="menu">
      <?php if (isset($_SESSION['user_name'])) {?>
      <li class="menu-item"><a href="documents">Documents</a></li>
      <li class="menu-item"><a href="shares">Shares</a></li>
      <?php } ?>
    </ul>
    <ul id="menu-right" class="menu">
      <?php if (isset($_SESSION['user_name'])) {?><p class="menu-item">Hello <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p><?php } ?>
      <?php if (isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 2) {?><li class="menu-item"><a href="dashboard">Admin</a></li><?php } ?>
      <?php if (isset($_SESSION['user_id'])) {?><li class="menu-item"><a href="logout">Logout</a></li><?php } ?>
    </ul>
  </nav>
</header>
