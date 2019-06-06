<?php 

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

<?php } 
