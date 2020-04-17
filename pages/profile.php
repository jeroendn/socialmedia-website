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
  $is_owner = false;
  if ($_SESSION['user_id'] == $user_data[0]['id']) {
    $is_owner = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Posting-it - Profile</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="profile" class="page-content">
      <?php if($is_owner) { ?> <form <?php } else { ?> <section <?php } ?> class="container mt-3 mb-3 pb-3 profile-header" action="php/ajax/profile_submit.php" method="post" enctype="multipart/form-data">
        <?php
        if ($user_check > 0) {
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
          <h4><?php echo htmlspecialchars($user_data[0]['username']) ?></h4>
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
        <?php if($is_owner) { ?>
        <div class="admin-buttons">
          <button class="btn btn-warning" task="update">Update profile</button>
        </div>
        <?php }
        }
        else {
          echo '<div class="alert">User has not been found!</div>';
        }
      if($is_owner) { ?> </form> <?php } else { ?> </section> <?php } ?>

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

            <div class="post">
              <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($post['username']); ?>" />
              <p class="message"><?php echo htmlspecialchars($post['text']); ?></p>
              <p class="like"><?php echo htmlspecialchars($likes[0]['likes']); ?></p>
              <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['post_id']); ?>">
            </div>

        <?php } } ?>
      </section>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
