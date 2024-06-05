<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (!empty($_POST["submit"])) {
		$loginquery = "SELECT * FROM admin WHERE username='$username' && password='" . md5($password) . "'";
		$result = mysqli_query($db, $loginquery);
		$row = mysqli_fetch_array($result);

		if (is_array($row)) {
			$_SESSION["adm_id"] = $row['adm_id'];
			header("refresh:1;url=dashboard.php");
		} else {
			$message = "Invalid Username or Password!";
		}
	}
}

if (isset($_POST['submit1'])) {
	if (
		empty($_POST['cr_user']) ||
		empty($_POST['cr_email']) ||
		empty($_POST['cr_pass']) ||
		empty($_POST['cr_cpass']) ||
		empty($_POST['code'])
	) {
		$message = "ALL fields must be fill";
	} else {


		$check_username = mysqli_query($db, "SELECT username FROM admin where username = '" . $_POST['cr_user'] . "' ");

		$check_email = mysqli_query($db, "SELECT email FROM admin where email = '" . $_POST['cr_email'] . "' ");

		$check_code = mysqli_query($db, "SELECT adm_id FROM admin where code = '" . $_POST['code'] . "' ");


		if ($_POST['cr_pass'] != $_POST['cr_cpass']) {
			$message = "Password not match";
		} elseif (!filter_var($_POST['cr_email'], FILTER_VALIDATE_EMAIL)) {
			$message = "Invalid email address please type a valid email!";
		} elseif (mysqli_num_rows($check_username) > 0) {
			$message = 'username Already exists!';
		} elseif (mysqli_num_rows($check_email) > 0) {
			$message = 'Email Already exists!';
		}
		if (mysqli_num_rows($check_code) > 0) {
			$message = "Unique Code Already Redeem!";
		} else {
			$result = mysqli_query($db, "SELECT id FROM admin_codes WHERE codes =  '" . $_POST['code'] . "'");

			if (mysqli_num_rows($result) == 0) {

				$message = "invalid code!";
			} else {

				$mql = "INSERT INTO admin (username,password,email,code) VALUES ('" . $_POST['cr_user'] . "','" . md5($_POST['cr_pass']) . "','" . $_POST['cr_email'] . "','" . $_POST['code'] . "')";
				mysqli_query($db, $mql);
				$success = "Admin Added successfully!";
			}
		}
	}
}
?>

<head>
	<meta charset="UTF-8">
	<title>Angkring Dashboard Login</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=poppins:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/green.css">


</head>

<body style="background-image: url('images/3de6d63b4c6d571102d44282490a1468.jpg');  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;">


	<div class="container">
		<div class="info">
			<h1>Administrator </h1><span> Login To Dashbord</span>
		</div>
	</div>
	<div class="form">
		<div>
			<img src="images/logo.jpg" style="width: 100%; height: 100%;" />
		</div>

		<form class="register-form" action="index.php" method="post">
			<input type="text" placeholder="Username" name="cr_user" />
			<input type="text" placeholder="Email address" name="cr_email" />
			<input type="password" placeholder="Password" name="cr_pass" />
			<input type="password" placeholder="Confirm password" name="cr_cpass" />
			<input type="password" placeholder="Unique-Code" name="code" />
			<input type="submit" name="submit1" value="Create" />
			<p class="message">Already registered? <a href="#">Sign In</a></p>
		</form>
		<span style="color:red;"><?php echo $message; ?></span>
		<span style="color:green;"><?php echo $success; ?></span>
		<form class="login-form" action="index.php" method="post">
			<input type="text" placeholder="Username" name="username" />
			<input type="password" placeholder="Password" name="password" />
			<input type="submit" name="submit" value="Login" />
			<p class="message">Not registered? <a href="#">Create an account</a></p>
		</form>

	</div>

	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='js/index.js'></script>

	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: #f6f5f7;
		}

		.container {
			position: relative;
			z-index: 1;
			max-width: 300px;
			margin: 0 auto;
		}

		.info {
			text-align: center;
			margin-bottom: 20px;
		}

		.info h1 {
			color: #333;
			font-size: 36px;
			font-weight: 300;
		}

		.info span {
			color: #666;
			font-size: 14px;
		}

		.form {
			position: relative;
			z-index: 1;
			background: #ffffff;
			max-width: 300px;
			margin: 0 auto 100px;
			padding: 45px;
			text-align: center;
			border-radius: 10px;
			box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2);
		}

		.thumbnail {
			background: #ffffff;
			border-radius: 100%;
			border: 4px solid #f3f3f3;
			box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2);
			margin: 0 auto 30px;
			width: 100px;
			height: 100px;
			overflow: hidden;
		}

		.thumbnail img {
			width: 100%;
		}

		input {
			outline: 0;
			background: #f2f2f2;
			width: 100%;
			border: 0;
			margin: 0 0 15px;
			padding: 15px;
			box-sizing: border-box;
			font-size: 14px;
		}

		button {
			text-transform: uppercase;
			outline: 0;
			background: #4CAF50;
			width: 100%;
			border: 0;
			padding: 15px;
			color: #ffffff;
			font-size: 14px;
			cursor: pointer;
		}

		.button {
			background-color: #4CAF50;
			border: none;
			color: white;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			transition-duration: 0.4s;
			cursor: pointer;
		}

		.button:hover {
			background-color: #45a049;
		}

		span.message {
			color: #888;
			font-size: 12px;
		}

		/* Styling for register form */
		.register-form {
			display: none;
		}

		/* Animation */
		@keyframes slideDown {
			0% {
				opacity: 0;
				transform: translateY(-100%);
			}

			100% {
				opacity: 1;
				transform: translateY(0);
			}
		}

		@keyframes slideUp {
			0% {
				opacity: 1;
				transform: translateY(0);
			}

			100% {
				opacity: 0;
				transform: translateY(-100%);
			}
		}

		.show {
			animation: slideDown 0.5s forwards;
		}

		.hide {
			animation: slideUp 0.5s forwards;
		}

		/* Responsive */
		@media (max-width: 480px) {
			.form {
				padding: 25px;
			}
		}
	</style>
</body>

</html>