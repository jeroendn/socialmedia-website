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
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Posting-it - Profile</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="profile" class="page-content">
      <section class="container mt-3 mb-3 pb-3 profile-header">
        <?php
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
          ?>

          <div class="profile-img">
            <img src="php/get_profile_icon.php?user=<?php echo $user_data[0]['username'] ?>" />
          </div>
          <div class="profile-info">
            <h4><?php echo $user_data[0]['username'] ?></h4>
            <button class="btn btn-primary" task="follow">follow</button>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
          <!-- <div class="admin-buttons">
            <button class="btn btn-warning" task="follow">follow</button>
            <button class="btn btn-warning" task="follow">follow</button>
            <button class="btn btn-warning" task="follow">follow</button>
          </div> -->
          <?php
        }
        else {
          echo '<div class="alert">User has not been found!</div>';
        }
        ?>
      </section>

      <section class="container mt-3 mb-3 profile-posts">
        <?php
        if ($user_check > 0) {
          ?>
          <p></p>
          <?php
        }
        ?>
      </section>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
