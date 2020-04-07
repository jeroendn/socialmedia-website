<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login");
}

include_once __DIR__ . '../../php/dbconnection.php';
include_once __DIR__ . '../../php/functions.php';
?>
