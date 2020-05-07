<?php
include_once __DIR__ . '../../php/session.php';

// check if url has a username
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_components = parse_url($url);
parse_str($url_components['query'], $params);

if (isset($params['user'])) {
  $username = $params['user'];

  // check if user exists and use if statement to check
  $sql = "SELECT COUNT(username) FROM user WHERE username = '" . $username . "' LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $user_check = $stmt->fetchColumn();
}
else {
  header('location: home');
}

$is_owner = false;

// get user data if the user exists
if ($user_check > 0) {
  try {
    $sql = "SELECT * FROM user WHERE username = '" . $username . "' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
    sql_error($e);
  }

  // check if current user is the owner of the page
  if ($_SESSION['user_id'] == $user_data[0]['id']) {
    $is_owner = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Posting-it - <?php echo $username; ?></title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="profile" class="page-content">
      <?php if($is_owner) { ?> <form <?php } else { ?> <section <?php } ?> class="container mt-3 mb-3 pb-3 profile-header" action="php/ajax/profile_submit.php" method="post" enctype="multipart/form-data">
        <?php
        if ($user_check > 0) {
        if ($user_data[0]['banned'] == false) {
        ?>
        <div class="profile-img">
          <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($user_data[0]['username']); ?>" />
          <?php if($is_owner) {?>
            <div class="overlay"></div>
            <input type="file" name="file_upload">
          <?php } ?>
        </div>
        <div class="profile-info">
          <!-- username -->
          <?php if($is_owner) {?>
          <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($user_data[0]['username']); ?>" placeholder="Your username">
          <?php } else { ?>
          <h4><?php echo htmlspecialchars($user_data[0]['username']); if ($user_data[0]['verified'] == true) { echo '<span class="verified"></span>'; } ?></h4>
          <?php } ?>
          <!-- follow button -->
          <?php if(!$is_owner) { $user_id = $user_data[0]['id']; include __DIR__ . '../../php/template_parts/follow_btn.php'; } ?>
          <!-- bio -->
          <?php if($is_owner) {?>
          <textarea class="form-control" name="bio" placeholder="Your bio"><?php echo htmlspecialchars($user_data[0]['bio']); ?></textarea>
          <?php } else { ?>
          <p><?php echo htmlspecialchars($user_data[0]['bio']); ?></p>
          <?php } ?>
        </div>
        <?php } else { ?>
          <div class="alert">User has been banned!</div>
        <?php } ?>
        <?php if($is_owner) { ?>
        <!-- profile control buttons -->
        <div class="profile-buttons">
          <button class="btn btn-warning" task="update">Update profile</button>
          <a class="btn btn-warning" href="logout">Logout</a>
        </div>
      <?php } ?>
      <!-- admin control buttons -->
      <?php if ($_SESSION['is_admin'] == true): ?>
      <div class="admin-buttons">
        <?php if($user_data[0]['verified'] == true) { ?><a class="btn btn-warning" task="unverify">Unverify user</a><?php } else { ?><a class="btn btn-warning" task="verify">Verify user</a><?php } ?>
        <?php if($user_data[0]['banned'] == true) { ?><a class="btn btn-danger" task="unban">Unban user</a><?php } else { ?><a class="btn btn-danger" task="ban">Ban user</a><?php } ?>
        <input type="hidden" value="<?php echo $user_data[0]['id']; ?>">
      </div>
      <?php endif; ?>
      <!-- follow count -->
      <div class="follow-count">
        <p><?php
        try {
          $sql = "SELECT COUNT(*) FROM follow INNER JOIN user ON follow.user_id = user.id WHERE follow.followed_user_id = " . $user_data[0]['id'] . " ";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $follower_count = $stmt->fetchColumn();
        }
        catch(Exception $e) {
          sql_error($e);
        }
        print_r($follower_count);
        ?> followers</p>
        <p><?php
        try {
          $sql = "SELECT COUNT(*) FROM follow INNER JOIN user ON follow.followed_user_id = user.id WHERE follow.user_id = " . $user_data[0]['id'] . " ";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $following_count = $stmt->fetchColumn();
        }
        catch(Exception $e) {
          sql_error($e);
        }
        print_r($following_count);
        ?> following</p>
        <?php if($user_data[0]['verified'] == true && $is_owner) { ?><p>You are verified <span class="verified"></span></p><?php } ?>
      </div>
      <?php } else { ?><div class="alert">User has not been found!</div><?php } ?>
      <?php if($is_owner) { ?> </form> <?php } else { ?> </section> <?php } ?>

      <?php if ($user_data[0]['banned'] == false || $is_owner == true) { ?>
      <section class="container mt-3 mb-3 profile-posts">
        <?php if ($user_check > 0) {
          try {
            $sql = "SELECT user.username, post.text, post.id as post_id
            FROM post
            INNER JOIN user ON post.user_id=user.id
            WHERE user.id = '" . $user_data[0]['id'] . "' AND post.deleted = 0
            ORDER BY post.date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }
          catch(Exception $e) {
            sql_error($e);
          }

          foreach ($posts as $post) {
            // get likes from db
            $sql = "SELECT COUNT(likes.user_id)  as likes
            FROM post
            INNER JOIN likes ON post.id=likes.post_id
            WHERE post.id = '" . $post['post_id'] . "' ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="post show">
              <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($post['username']); ?>" />
              <p class="message"><?php echo preg_replace('/(?<!\S)http:\/\/([0-9a-zA-Z.]+)/', '<a href="http://$1" target="_blank">$1</a>', preg_replace('/(?<!\S)https:\/\/([0-9a-zA-Z.]+)/', '<a href="https://$1" target="_blank">$1</a>', htmlspecialchars($post['text']))); ?></p>
              <p class="like"><?php echo htmlspecialchars($likes[0]['likes']); ?></p>
              <?php if($is_owner) { ?><button class="delete"><i class="fas fa-times-circle"></i></button><?php } ?>
              <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['post_id']); ?>">
            </div>

        <?php } } ?>
      </section>
      <?php } ?>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
