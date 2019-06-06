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
		<title>Bild Verwaltung</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
		<link rel="stylesheet" href="./res/css/style.css">
	</head>

	<body>
		<?php 
			include './inc/header.php';
			include './inc/registrieren.php';

			if ($_GET['url'] == 'home') { ?>

		<main>
			<div class="container">
				<div class="text-center mt-3">
					<h1>BildVerwaltung</h1>
					<h2>Webtechnologie 2 - Abschlussprojekt</h2>
					<hr>
				</div>

				<p class="lead text-center">
					Zum Abschluss der LV Webtechnologien 2 wird ein Projekt umgesetzt – ein Bildverwaltungstool.
					Das Projekt wird von den Studenten Daniel Krottendorfer und Josef Koch umgesetzt und bietet folgende Features und Technologien:
				</p>

				<div class="row mt-4">
					<div class="col-12 col-lg-6">
						<h3>Features</h3>
						<ul class="list-group">
							<li class="list-group-item">i. Registrationsmöglichkeit für User</li>
							<li class="list-group-item">ii. Hochladen eigener Bilder</li>
							<li class="list-group-item">iii. Verwaltung und Darstellung der Bilder</li>
							<li class="list-group-item">iv. Positionierung der Bilder auf einer Karte</li>
							<li class="list-group-item">v. Freigabe eigener Bilder für andere User</li>
							<li class="list-group-item">vi. Tagging (Beschlagwortung) von Bildern</li>
							<li class="list-group-item">vii. Einfache Formen der Bildbearbeitung</li>
							<li class="list-group-item">viii. Userverwaltung durch den Administrator</li>
						</ul>

					</div>
					<div class="col-12 col-lg-6 mt-3 mt-lg-0">
						<h3>Technologien</h3>
						<ul class="list-group">
							<li class="list-group-item">i. JavaScript & jQuery (AJAX)</li>
							<li class="list-group-item">ii. PHP & XML bzw. JSON </li>
							<li class="list-group-item">iii. PHP & OOP </li>
							<li class="list-group-item">iv. Fileuploads </li>
							<li class="list-group-item">v. Sessions und Cookies </li>
						</ul>
					</div>
				</div>
				<hr class="mt-5">

				<h3 class="mt-5 text-center">Team</h3>

				<!-- Daniel Krottendorfer -->
				<div id="daniel" class="row align-items-center justify-content-sm-center mt-2 py-5 rounded">
					<div class="col-12 col-sm-3 col-md-4 text-center">
						<img class="img-fluid rounded-circle mb-2 teampics" src="./res/img/daniel.jpg" alt="Daniel Krottendorfer" />
					</div>
					<div class="col-12 col-sm-9 col-md-8 col-lg-5 text-center text-sm-left">
						<h4 class="">Daniel Krottendorfer</h4>
						<table class="table">
							<tr>
								<td>Username</td>
								<td>if18b030</td>
							</tr>
							<tr>
								<td>E-Mail</td>
								<td><a class="text-dark" href="mailto:if18b030@technikum-wien.at">if18b030@technikum-wien.at</a></td>
							</tr>
							<tr>
								<td>Verband / Gruppe</td>
								<td>2C</td>
							</tr>
						</table>
					</div>
				</div>

				<!-- Josef Koch -->
				<div id="josef" class="row align-items-center justify-content-sm-center mt-3 py-5 rounded">
					<div class="col-12 col-sm-3 col-md-4 text-center order-sm-2">
						<img class="img-fluid rounded-circle mb-2 teampics" src="./res/img/josef.jpg" alt="Josef Koch" />
					</div>
					<div class="col-12 col-sm-9 col-md-8 col-lg-5 text-center text-sm-right order-sm-1">
						<h4 class="">Josef Koch</h4>
						<table class="table">
							<tr>
								<td>Username</td>
								<td>if18b061</td>
							</tr>
							<tr>
								<td>E-Mail</td>
								<td><a class="text-dark" href="mailto:if18b061@technikum-wien.at">if18b061@technikum-wien.at</a></td>
							</tr>
							<tr>
								<td>Verband / Gruppe</td>
								<td>2C</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</main>

		<?php } ?>

		<!-- Footer -->
		<footer>
			<div class="container-fluid bg-dark text-center text-light py-2">
				<a class="text-light" href="./index.php?url=home#daniel">Daniel Krottendorfer</a> |
				<a class="text-light" href="./index.php?url=home#josef">Josef Koch</a><br />
				<a class="text-light" target="_blank" href="http://www.technikum-wien.at">FH Technikum</a> 2019
			</div>
		</footer>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="./res/js/regValidation.js"></script>
	</body>

</html>
