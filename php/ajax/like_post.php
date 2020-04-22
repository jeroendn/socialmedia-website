<?php
session_start();
include_once '../../php/dbconnection.php';

$post_id = $_POST['post_id'];

if ($_POST['post_id'] != '' && $_SESSION['user_id'] != '') {
  $sql = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
  $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
  $stmt->execute();
}
else {
  die(header("HTTP/1.0 400 Empty variables"));
}
