<?php
session_start();
include_once __DIR__ . '../../php/dbconnection.php';

$dir = $_SERVER['DOCUMENT_ROOT'] . '/media/';
$user = (!empty($_GET['user'])) ? basename($_GET['user']) : false;

$sql = "SELECT id FROM user WHERE username = '" . $user . "' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$file_dir = $dir . $user . $user_data[0]['id'] . '/profile_icon.png';

if($user !== false and file_exists($file_dir)) {
   readfile($file_dir);
   exit;
}
header("HTTP/1.0 404 Not Found");
