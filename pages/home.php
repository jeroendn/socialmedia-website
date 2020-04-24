<?php
include_once __DIR__ . '../../php/session.php';
?>

<!DOCTYPE html>
<html lang="en">
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
          $sql = "SELECT user.username, post.text, post.id as post_id
          FROM post
          INNER JOIN follow ON post.user_id=follow.followed_user_id
          INNER JOIN user ON follow.followed_user_id=user.id
          WHERE
          follow.user_id = '" . $_SESSION['user_id'] . "' AND
          post.deleted = false AND
          user.banned = false AND
          post.id NOT IN (SELECT post_id FROM post INNER JOIN seen ON post.id=seen.post_id WHERE seen.user_id = '" . $_SESSION['user_id'] . "') AND
          post.id NOT IN (SELECT post_id FROM post INNER JOIN likes ON post.id=likes.post_id WHERE likes.user_id = '" . $_SESSION['user_id'] . "')
          ORDER BY post.date DESC LIMIT 100";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }

        // SELECT user.username, post.text, post.id as post_id, COUNT(likes.post_id) as likes
        //           FROM post
        //           INNER JOIN follow ON post.user_id=follow.followed_user_id
        //           INNER JOIN user ON follow.followed_user_id=user.id
        //           INNER JOIN likes ON post_id=likes.post_id
        //           WHERE
        //           follow.user_id = 18 AND
        //           post.deleted = 0 AND
        //           post.id NOT IN (SELECT post_id FROM post INNER JOIN seen ON post.id=seen.post_id WHERE seen.user_id = 18) AND
        //           post_id IN (SELECT user_id FROM likes WHERE likes.post_id = post_id)
        //           GROUP BY post.id
        //           ORDER BY post.date DESC LIMIT 100

        foreach ($posts as $post) {
          // get likes from db
          $sql = "SELECT COUNT(likes.user_id) as likes
          FROM post
          INNER JOIN likes ON post.id=likes.post_id
          WHERE post.id = '" . $post['post_id'] . "' ";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <div class="post">
            <a href="<?php echo 'profile?user=' . $post['username']; ?>"><img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($post['username']); ?>" /></a>
            <p class="user"><?php echo htmlspecialchars($post['username']); ?></p>
            <p class="message"><?php echo htmlspecialchars($post['text']); ?></p>
            <p class="like"><?php echo htmlspecialchars($likes[0]['likes']); ?></p>
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['post_id']); ?>">
          </div>
          <?php
        }
        ?>
        <div class="post">
          <p class="message">No posts to show.<br>You have seen everything!<br>Or <a href="follows">start</a> following some people.</p>
        </div>
      </section>

      <section class="container mt-4 mb-4 comment-section">
        <div class="write-comment">
          <span class="comment-count">0 comments</span>
          <textarea class="form-control" placeholder="Write a comment"></textarea>
          <button class="btn btn-warning">Comment</button>
        </div>
        <div class="comments"></div>
      </section>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
