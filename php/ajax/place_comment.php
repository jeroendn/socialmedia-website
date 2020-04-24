<?php
session_start();
include_once '../../php/dbconnection.php';

$post_id = $_POST['post_id'];
$comment = $_POST['comment'];

if ($post_id != '' && $comment != '') {
  $sql = "INSERT INTO comment (post_id, user_id, text) VALUES (:post_id, :user_id, :comment)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt->execute();
}
else {
  die(header("HTTP/1.0 400 Empty variables"));
}
