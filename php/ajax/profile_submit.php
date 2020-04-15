<?php
session_start();
include_once __DIR__ . '../../dbconnection.php';

// save profile img
$file_name = 'profile_icon.png';

$dir = $_SERVER['DOCUMENT_ROOT'] . '/media/' . str_replace(' ', '_', $_SESSION['username']) . $_SESSION['user_id'] . '/';

move_uploaded_file($_FILES["file_upload"]["tmp_name"], $dir . $file_name);

// save profile data to database
$username = str_replace(' ', '_', $_POST['username']);
$bio = $_POST['bio'];

try {
  $sql = "SELECT COUNT(*) FROM user WHERE username = '" . $username . "' AND id != '" . $_SESSION['user_id'] . "' LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $username_check = $stmt->fetchColumn();
}
catch(Exception $e) {
  header('location: ../../profile?user=' . htmlspecialchars($_SESSION['username']) . '&update=check_fail');
  exit;
}

if ($username_check > 0) {
  header('location: ../../profile?user=' . htmlspecialchars($_SESSION['username']) . '&update=occupied');
  exit;
}

try {
  $sql = "UPDATE user SET username=:username, bio=:bio WHERE id = '" . $_SESSION['user_id'] . "' ";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':username', $username, PDO::PARAM_STR);
  $stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
  $stmt->execute();

  $_SESSION['username'] = $username;
  $newdir = $_SERVER['DOCUMENT_ROOT'] . '/media/' . str_replace(' ', '_', $_SESSION['username']) . $_SESSION['user_id'] . '/';
  rename($dir, $newdir);
  header('location: ../../profile?user=' . htmlspecialchars($_SESSION['username']) . '&update=success');
  exit;
}
catch(Exception $e) {
  header('location: ../../profile?user=' . htmlspecialchars($_SESSION['username']) . '&update=check_fail');
  exit;
}

header('location: ../../profile?user=' . htmlspecialchars($_SESSION['username']) . '&update=fail');
