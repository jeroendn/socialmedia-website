<?php
session_start();
include_once '../../php/dbconnection.php';

$mail = $_POST['mail'];
$password = $_POST['password'];
$repeated_password = $_POST['repeated-password'];
$name = str_replace(' ', '_', $_POST['username']);

if ($mail != '' && $password != '' && $repeated_password != '' && $name != '' && filter_var($mail, FILTER_VALIDATE_EMAIL)) {

  if ($password != $repeated_password) {
    die(header("HTTP/1.0 400 Passwords aren't similar"));
  }

  $sql = "SELECT COUNT(mail) FROM user WHERE mail=:mail";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
  $stmt->execute();
  $mail_check = $stmt->fetchColumn();

  if ($mail_check > 0) {
    die(header("HTTP/1.0 400 E-mail is already used"));
  }

  $sql = "SELECT COUNT(username) FROM user WHERE username=:name";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->execute();
  $name_check = $stmt->fetchColumn();

  if ($name_check > 0) {
    die(header("HTTP/1.0 400 Username is already taken"));
  }

  $sql = "INSERT INTO user (mail, username, password) VALUES (:mail, :name, :hashedpass)";
  $stmt = $conn->prepare($sql);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':hashedpass', $hashed_password, PDO::PARAM_STR);
  $stmt->execute();

  $sql = "SELECT id FROM user WHERE mail=:mail LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetchAll();

  // create a folder for the user it's files
  mkdir($_SERVER['DOCUMENT_ROOT'] . '/media/' . str_replace(' ', '_', $name) . $user[0]['id']);

  $_SESSION['is_first_login'] = 1;
  // sent to login in order to set session variables
  include 'login_submit.php';
}
else {
  die(header("HTTP/1.0 400 Empty fields"));
}
