<?php
include_once __DIR__ . '../../php/session.php';

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_components = parse_url($url);
parse_str($url_components['query'], $params);

if (isset($params['id'])) {
  // get post data
  $sql = "SELECT user.username, user.verified, user.banned, post.text, post.id as post_id
  FROM post
  INNER JOIN user ON post.user_id=user.id
  WHERE post.id = '" . $params['id'] . "' AND post.deleted = 0 AND user.banned = 0
  ORDER BY post.date DESC
  LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $post = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // get likes
  $sql = "SELECT COUNT(likes.user_id) as likes
  FROM post
  INNER JOIN likes ON post.id=likes.post_id
  WHERE post.id = '" . $params['id'] . "' ";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
  header('location: home');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Posting-it - Post from <?php echo $post[0]['username']; ?></title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="post" class="page-content">
      <?php if (!empty($post[0])) { ?>
      <section class="container posts mt-5 pb-3">
        <div class="post show">
          <a href="<?php echo 'profile?user=' . $post[0]['username']; ?>"><img src="php/get_profile_icon.php?user=<?php echo htmlspecialchars($post[0]['username']); ?>" /></a>
          <p class="user"><?php echo htmlspecialchars($post[0]['username']); if($post[0]['verified'] == true) { ?><span class="verified"></span><?php } ?></p>
          <p class="message"><?php echo preg_replace('/(?<!\S)http:\/\/([0-9a-zA-Z.]+)/', '<a href="http://$1" target="_blank">$1</a>', preg_replace('/(?<!\S)https:\/\/([0-9a-zA-Z.]+)/', '<a href="https://$1" target="_blank">$1</a>', htmlspecialchars($post[0]['text']))); ?></p>
          <p class="like"><?php echo htmlspecialchars($likes[0]['likes']); ?></p>
          <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post[0]['post_id']); ?>">
        </div>
      </section>

      <?php include_once __DIR__ . '../../php/template_parts/comment_section.php'; ?>

      <?php } else { ?>
      <section class="container text-center mt-5 pb-3">
        <h2>Failed to load this post!</h2>
        <h4  class="mb-4">The following could be the issue:</h4>
        <p class="mb-0">- Post has been deleted</p>
        <p class="mb-0">- User has been banned</p>
        <p class="mb-0">- User has removed their account</p>
      </section>
      <?php } ?>
    </main>

    <?php include_once __DIR__ . '../../php/footer.php'; ?>
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
