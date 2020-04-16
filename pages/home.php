<?php
include_once __DIR__ . '../../php/session.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Posting-it - Feed</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="feed" class="page-content">
      <section class="container mt-5 pb-3">
        <?php
        // get posts from db
        try {
          $sql = "SELECT *, post.id as post_id
          FROM post
          INNER JOIN follow ON post.user_id=follow.followed_user_id
          INNER JOIN user ON follow.followed_user_id=user.id
          WHERE
          follow.user_id = '" . $_SESSION['user_id'] . "' AND
          post.deleted = 0
          ORDER BY post.date DESC LIMIT 100";
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

          // check if post has been seen
          $sql = "SELECT COUNT(*)
          FROM post
          INNER JOIN seen ON post.id=seen.post_id
          WHERE
          seen.post_id = '" . $post['post_id'] . "' AND
          seen.user_id = '" . $_SESSION['user_id'] . "' ";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $seen_check = $stmt->fetchColumn();

          if ($seen_check <= 0) { ?>
          <div class="post">
            <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($post['username']); ?>" />
            <p class="user"><?php echo htmlspecialchars($post['username']); ?></p>
            <p class="message"><?php echo htmlspecialchars($post['text']); ?></p>
            <p class="likes"><?php echo htmlspecialchars($likes[0]['likes']); ?></p>
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['post_id']); ?>">
          </div>
          <?php
          }
        }
        ?>

      </section>

      <section class="container mt-3">

      </section>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
