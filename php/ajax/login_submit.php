<?php
session_start();
include_once '../../php/dbconnection.php';

if ($_POST['mail'] != '' && $_POST['password'] != '') {

	$sql = "SELECT user_id, user_password, user_role, user_name, user_mail FROM user WHERE user_mail=:mail";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (password_verify($_POST['password'], $user['user_password'])) {
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['user_name'] = $user['user_name'];
		$_SESSION['user_role_id'] = $user['user_role'];
	}
}
