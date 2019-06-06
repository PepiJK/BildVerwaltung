<?php 
	session_start();

	include './utility/DB.class.php';
	include "./model/USER.class.php";

	// create database object -> connect to database
	$db = new DB();

	// if user is logged in create user object
	if(isset($_SESSION['username'])) {
		$user = new USER($_SESSION['username'], $_SESSION['vorname'], $_SESSION['nachname'], $_SESSION['email'], $_SESSION['password'], $_SESSION['admin']);
	}

	// standard url = home
	if (!isset($_GET['url'])) {
		$_GET['url'] = 'home';
	}

?>

<!DOCTYPE html>
<html lang="de">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BildVerwaltung</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
		<link rel="stylesheet" href="./res/css/style.css">
	</head>

	<body>
		<!-- php include for each section -->
		<?php 
			include './inc/header.php';
			include "./inc/home.php";
			include "./inc/hilfe.php";
			include "./inc/impressum.php";
			include './inc/registrieren.php';
			include './inc/profilverwaltung.php';
		?>

		<!-- Footer -->
		<footer class="bg-dark">
			<div class="container bg-dark text-center text-light py-2">
				<div class="row">
					<div class="col-12 col-md text-center text-md-left">
						<a class="text-light" href="./index.php?url=home#daniel">Daniel Krottendorfer</a> &
						<a class="text-light" href="./index.php?url=home#josef">Josef Koch</a>
					</div>
					<div class="col-12 col-md text-center">
						<a class="text-light" href="./index.php?url=impressum">Impressum</a> //
						<a class="text-light" href="./index.php?url=hilfe">Hilfe</a>
					</div>
					<div class="col-12 col-md text-center text-md-right">
						<a class="text-light" target="_blank" href="http://www.technikum-wien.at">FH Technikum</a> 2019
					</div>
				</div>
			</div>
		</footer>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="./res/js/regValidation.js"></script>
	</body>

</html>
