<?php
session_start();
include_once '../../php/dbconnection.php';

if ($_POST['mail'] != '' && $_POST['password'] != '') {

	$sql = "SELECT id, password, username, mail FROM user WHERE mail=:mail";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (password_verify($_POST['password'], $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
	}
	else {
	  die(header("HTTP/1.0 400 Incorrect login data"));
	}
}
else {
  die(header("HTTP/1.0 400 Empty fields"));
}
