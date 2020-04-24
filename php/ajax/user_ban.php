<?php
session_start();
include_once '../../php/dbconnection.php';

$user_id = $_POST['user_id'];

$sql = "UPDATE user SET banned='1' WHERE id = '" . $user_id . "' ";
$stmt = $conn->prepare($sql);
$stmt->execute();
