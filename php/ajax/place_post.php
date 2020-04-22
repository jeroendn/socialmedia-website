<?php
session_start();
include_once '../../php/dbconnection.php';
include_once '../../php/functions.php';

$message = substr($_POST['message'], 0, 255);

if ($message != '') {
  try {
    $sql = "INSERT INTO post (user_id, text) VALUES (:user_id, :message)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
  }
  catch(Exception $e) {
    sql_error($e);
  }
}

header("Location: ../../profile?user=" . $_SESSION['username']);
