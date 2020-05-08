<?php
include_once __DIR__ . '../../php/session.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Posting-it - Following</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="follows" class="page-content">
      <section class="container mt-3">
        <h4 class="text-center">People who</h4>
        <p class="follow-toggle text-center mb-4"><span class="text-first">you</span><span class="toggle-icon"></span><span class="text-last">follow</span></p>
        <div class=" follow-you active">
        <?php
        try {
          $sql = "SELECT * FROM follow INNER JOIN user ON follow.followed_user_id = user.id WHERE follow.user_id = '" . $_SESSION['user_id'] . "' AND user.banned = false";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }

        foreach ($user_data as $user) { ?>
          <div class="card mb-2 pr-2 pl-2 pt-1 pb-1">
            <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($user['username']); ?>" />
            <a href="<?php echo 'profile?user=' . htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); if ($user['verified'] == true) { echo '<span class="verified"></span>'; } ?></a>
            <?php $user_id = $user['id']; $username = $user['username']; include __DIR__ . '../../php/template_parts/follow_btn.php'; ?>
          </div>
        <?php
        }
        ?>
        </div>
        <div class="you-follow">
        <?php
        try {
          $sql = "SELECT * FROM follow INNER JOIN user ON follow.user_id = user.id WHERE follow.followed_user_id = '" . $_SESSION['user_id'] . "' AND user.banned = false";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }

        foreach ($user_data as $user) { ?>
          <div class="card mb-2 pr-2 pl-2 pt-1 pb-1">
            <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($user['username']); ?>" />
            <a href="<?php echo 'profile?user=' . htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); if ($user['verified'] == true) { echo '<span class="verified"></span>'; } ?></a>
            <?php $user_id = $user['id']; $username = $user['username']; include __DIR__ . '../../php/template_parts/follow_btn.php'; ?>
          </div>
        <?php
        }
        ?>
        </div>
        <h4 class="text-center mt-4 mb-4">Suggestions to follow</h4>
        <?php
        try {
          $sql = "SELECT * FROM user WHERE id != '" . $_SESSION['user_id'] . "' AND banned = false ORDER BY rand() LIMIT 10";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }

        foreach ($user_data as $user) { ?>
          <div class="card mb-2 pr-2 pl-2 pt-1 pb-1">
            <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($user['username']); ?>" />
            <a href="<?php echo 'profile?user=' . htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); if ($user['verified'] == true) { echo '<span class="verified"></span>'; } ?></a>
            <?php $user_id = $user['id']; $username = $user['username']; include __DIR__ . '../../php/template_parts/follow_btn.php'; ?>
          </div>
        <?php
        }
        ?>
      </section>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
