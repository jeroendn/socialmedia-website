<?php
// var $username & $user_id must be defined in order to work correctly

try {
  $sql = "SELECT COUNT(followed_user_id) FROM follow WHERE followed_user_id = '" . $user_id . "' LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $follow_check = $stmt->fetchColumn();
}
catch(Exception $e) {
  sql_error($e);
}

if ($follow_check > 0) {
  ?>
  <button class="btn btn-primary btn-follow" user="<?php echo htmlspecialchars($username); ?>">Follow</button>
  <button class="btn btn-primary btn-unfollow active" user="<?php echo htmlspecialchars($username); ?>">Unfollow</button>
  <?php
}
else {
  ?>
  <button class="btn btn-primary btn-follow active" user="<?php echo htmlspecialchars($username); ?>">Follow</button>
  <button class="btn btn-primary btn-unfollow" user="<?php echo htmlspecialchars($username); ?>">Unfollow</button>
  <?php
}
