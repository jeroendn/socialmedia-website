<?php
session_start();
include_once __DIR__ . '../../dbconnection.php';

// save the file to directory
// $file_name = basename($_POST["file"]);

var_dump($_POST);

die(header("HTTP/1.0 400 ERROR"));

// print contents
foreach ($_FILES["file_upload"] as $key) {
  echo $key . '<br>';
}

$dir = $_SERVER['DOCUMENT_ROOT'] . '/media/' . str_replace(' ', '_', $_SESSION['username']) . $_SESSION['user_id'] . '/';
echo $dir . $file_name;

move_uploaded_file($_FILES["file_upload"]["tmp_name"], $dir . $file_name);

// save file to SQLiteDatabase
// $sql = "INSERT INTO document (document_name, user_id) VALUES (:document_name, :user_id)";
// $stmt = $conn->prepare($sql);
// $stmt->bindParam(':document_name', $file_name, PDO::PARAM_STR);
// $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
// $stmt->execute();

header('location: ../../home');
