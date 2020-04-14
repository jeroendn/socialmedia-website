<?php
include_once __DIR__ . '../../php/session.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Posting-it - Following</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="follows" class="page-content">
      <section class="container mt-3">
        <?php
        try {
          $sql = "SELECT * FROM follow WHERE user_id = '" . $_SESSION['user_id'] . "' ";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }

        foreach ($user_data as $user) {
          ?><div><?php echo $user['followed_user_id']; ?></div><?php
        }
        ?>
      </section>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
