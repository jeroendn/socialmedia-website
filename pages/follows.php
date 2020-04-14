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
          $sql = "SELECT * FROM follow INNER JOIN user ON follow.followed_user_id = user.id WHERE user_id = '" . $_SESSION['user_id'] . "' ";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e) {
          sql_error($e);
        }

        foreach ($user_data as $user) {?>
          <div class="card mb-2 pr-3 pl-3">
            <img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($user['username']); ?>" />
            <p><?php echo $user['username']; ?></p>
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
