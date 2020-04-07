<?php
session_start();
include_once '../../php/dbconnection.php';

$mail = $_POST['mail'];
$password = $_POST['password'];
$name = $_POST['username'];
$role = 1; // user

if ($mail != '' && $password != '' && $name != '' && filter_var($mail, FILTER_VALIDATE_EMAIL)) {

  $sql = "SELECT COUNT(user_mail) FROM user WHERE user_mail=:mail";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
  $stmt->execute();
  $result_check = $stmt->fetchColumn();

  // check if mail exists in db
  if ($result_check <= 0) {
    $sql = "INSERT INTO user (user_mail, user_name, user_password, user_role) VALUES (:mail, :name, :hashedpass, :role)";
    $stmt = $conn->prepare($sql);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':hashedpass', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "SELECT user_id FROM user WHERE user_mail=:mail LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetchAll();

    // create a folder for the user it's files
    mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . str_replace(' ', '_', $name) . $user[0]['user_id']);

    // sent to login in order to set session variables
    include 'login_submit.php';
  }
  else {
    // does already exist
  }
}
