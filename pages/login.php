<?php
session_start();
include_once __DIR__ . '../../php/dbconnection.php';
if (isset($_SESSION['user_id'])) {
	header("Location: documents");
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Posting-it - Login</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php' ?>
  </head>

  <body>
    <!-- header -->
    <?php include_once __DIR__ . '../../php/header.php' ?>

    <main id="login" class="page-content">
			<div class="container card mt-5 pt-3 pr-5 pb-2 pl-5">
				<p></p>
			</div>
      <div class="container card mt-4 p-5">
				<h4>Log in:</h4>
        <form id="login-form">
          <!-- email -->
          <!-- <label class="text-light" for="mail">E-mail:</label> -->
          <input class="form-control" type="text" name="mail" id="mail" placeholder="E-mail">
          <!-- password -->
          <!-- <label class="text-light" for="password">Password:</label> -->
          <input class="form-control" type="password" name="password" id="password" placeholder="Password">
          <!-- submit -->
          <input class="btn btn-primary font-weight-bold" type="submit" value="Log In">
        </form>
				<h4 class="mt-5">Register:</h4>
				<form id="register-form">
					<!-- username -->
					<!-- <label class="text-light" for="username">Username:</label> -->
					<input class="form-control" type="text" name="username" id="username" placeholder="Username">
					<!-- email -->
					<!-- <label class="text-light" for="mail">E-mail:</label> -->
					<input class="form-control" type="text" name="mail" id="mail" placeholder="E-mail">
					<!-- password -->
					<!-- <label class="text-light" for="password">Password:</label> -->
					<input class="form-control" type="password" name="password" id="password" placeholder="Password">
					<!-- submit -->
					<input class="btn btn-primary font-weight-bold" type="submit" value="Sign Up">
				</form>
      </div>
    </main>

    <!-- footer -->
    <?php include_once __DIR__ . '../../php/footer.php' ?>

    <!-- scripts -->
    <?php include_once __DIR__ . '../../php/js_include.php' ?>
  </body>
</html>
