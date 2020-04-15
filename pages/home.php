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
      <section class="container mt-5">
        <?php
        try {
          // query needs to be replaced with one that checkes on follow and seen and like
          $sql = "SELECT * FROM post WHERE
          post.user_id = '" . $_SESSION['user_id'] . "' AND
          post.deleted = 0
          ORDER BY post.date DESC LIMIT 1";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }


        foreach ($posts as $post) {
          ?><div class="post"><p><?php echo $post['text']; ?></p></div><?php
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
