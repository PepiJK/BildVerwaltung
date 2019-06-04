<?php

if ($_GET['url'] == "userregistration") { ?>

<main>
	<div class="container mt-3">
		<h1>User Registrieren</h1>
		<form action="./index.php?url=userregistration" method="POST" class="mt-3">
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regUser">Username: </label>
				<div class="col">
					<input type="text" name="regUser" class="form-control" id="regUser" placeholder="Username">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regPwd">Passwort: </label>
				<div class="col">
					<input type="password" name="regPwd" class="form-control" id="regPwd" placeholder="Password">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regPwdWh">Passwort wiederholen: </label>
				<div class="col">
					<input type="password" name="regPwdWh" class="form-control" id="regPwdWh" placeholder="Password">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regVor">Vorname: </label>
				<div class="col">
					<input type="text" name="regVor" class="form-control" id="regVor" placeholder="Vorname">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regNach">Nachname: </label>
				<div class="col">
					<input type="text" name="regNach" class="form-control" id="regNach" placeholder="Nachname">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regEmail">E-Mail: </label>
				<div class="col">
					<input type="email" name="regEmail" class="form-control" id="regEmail" placeholder="E-Mail">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-10">
					<button type="submit" class="btn btn-primary">Registrieren</button>
				</div>
			</div>
		</form>
	</div>
</main>

<?php } ?>
