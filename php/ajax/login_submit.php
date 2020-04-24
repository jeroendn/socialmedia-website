<?php
session_start();
include_once '../../php/dbconnection.php';

if ($_POST['mail'] != '' && $_POST['password'] != '') {

	$sql = "SELECT id, password, username, mail, admin, banned FROM user WHERE mail=:mail";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (password_verify($_POST['password'], $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = htmlspecialchars($user['username']);
		$_SESSION['is_admin'] = $user['admin'];
		$_SESSION['is_banned'] = $user['banned'];
		if (!isset($_SESSION['is_first_login'])) { $_SESSION['is_first_login'] = 0;	}
	}
	else {
	  die(header("HTTP/1.0 400 Incorrect login data"));
	}
}
else {
  die(header("HTTP/1.0 400 Empty fields"));
}
