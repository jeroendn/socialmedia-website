<?php
session_start();
include_once '../../php/dbconnection.php';

$post_id = $_POST['post_id'];

$sql = "UPDATE post SET deleted='1' WHERE id = '" . $post_id . "' AND user_id = '" . $_SESSION['user_id'] . "' ";
$stmt = $conn->prepare($sql);
$stmt->execute();
