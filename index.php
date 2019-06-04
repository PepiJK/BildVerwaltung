<?php 
	session_start();

	// standard link = Home
	if (!isset($_GET['url'])) {
		$_GET['url'] = 'home';
	}
	//$_SESSION['loggedin'] = true;
	//$_SESSION['admin'] = true;

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
			include "./inc/header.php";
			include "./inc/registrieren.php";

			if ($_GET['url'] == "home") { ?>

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
			</div>
		</main>

		<?php } ?>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	</body>

</html>
