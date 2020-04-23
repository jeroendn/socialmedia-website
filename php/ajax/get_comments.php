<?php
session_start();
include_once '../../php/dbconnection.php';

$post_id = $_POST['post_id'];

if ($_POST['post_id'] != '') {
  $sql = "SELECT user.username, comment.text FROM comment INNER JOIN user ON comment.user_id=user.id WHERE comment.post_id=:post_id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $stmt->execute();
  $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($comments);
}
else {
  die(header("HTTP/1.0 400 User_id not defined"));
}
