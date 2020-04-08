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
    <?php include_once __DIR__ . '../../php/head.php'; ?>
  </head>

  <body>
    <!-- header -->
    <?php include_once __DIR__ . '../../php/header.php'; ?>

    <main id="login" class="page-content">
			<div class="container card mt-5 pt-3 pr-5 pl-5">
				<p class="text-center font-weight-bold">Create your own Posting-it account and start sharing and interacting!</p>
			</div>
      <div class="container card mt-4 p-5">

				<h4 class="text-center">Sign in</h4>
        <form id="login-form">
          <input class="form-control text-center" type="text" name="mail" id="mail" placeholder="e-mail">
          <input class="form-control text-center" type="password" name="password" id="password" placeholder="password">
          <input class="btn btn-warning font-weight-bold" type="submit" value="Log In">
        </form>

				<h4 class="mt-5 text-center">Create account</h4>
				<form id="register-form">
					<input class="form-control text-center" type="text" name="username" id="username" placeholder="username">
					<input class="form-control text-center" type="text" name="mail" id="mail" placeholder="e-mail">
					<input class="form-control text-center" type="password" name="password" id="password" placeholder="password">
					<input class="form-control text-center" type="password" name="repeated-password" id="repeated-password" placeholder="repeat password">
					<input class="btn btn-warning font-weight-bold" type="submit" value="Sign Up">
				</form>

      </div>
    </main>

    <!-- footer -->
    <?php include_once __DIR__ . '../../php/footer.php'; ?>

    <!-- scripts -->
    <?php include_once __DIR__ . '../../php/js_include.php'; ?>
  </body>
</html>
