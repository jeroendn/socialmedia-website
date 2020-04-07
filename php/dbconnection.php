<?php
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "socialmedia";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dBName",$dBUsername,$dBPassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
  ?><p style="display: block; background: #f00; color: #fff; text-align: center; margin-bottom: 0;">Couldn't connenct to database: <?php echo $e->getMessage();?></p><?php
}
