<?php
if ($_GET['url'] == 'userregistration') { 
	if ((!empty($_POST['regVor'])) && (!empty($_POST['regNach'])) && (!empty($_POST['regUser'])) && (!empty($_POST['regPwd'])) && (!empty($_POST['regPwdWh']))&& (!empty($_POST['regEmail']))) {
		$statement = $db->saveUser($_POST['regUser'], $_POST['regVor'], $_POST['regNach'], $_POST['regEmail'], $_POST['regPwd']);

		if ($statement === true) {
			$regSuccess = '<div id="dbValidate" class="alert alert-success" role="alert">User ' . $_POST['regUser'] . ' wurde erfolgreich registriert!</div>';
		} else {
			$regSuccess = '<div id="dbValidate" class="alert alert-danger" role="alert">User konnte nicht registriert werden! ' . $statement->error . '</div>';
		}
	}
?>

<main>
	<div class="container mt-3">
		<h1>User Registrieren</h1>
		<?php if (isset($regSuccess)) echo $regSuccess ?>
		<form action="./index.php?url=userregistration" method="POST" id="regForm" class="mt-3">
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regUser">Username: </label>
				<div class="col">
					<input type="text" name="regUser" class="form-control" id="regUser" placeholder="Username" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regVor">Vorname: </label>
				<div class="col">
					<input type="text" name="regVor" class="form-control" id="regVor" placeholder="Vorname" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regNach">Nachname: </label>
				<div class="col">
					<input type="text" name="regNach" class="form-control" id="regNach" placeholder="Nachname" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regEmail">E-Mail: </label>
				<div class="col">
					<input type="email" name="regEmail" class="form-control" id="regEmail" placeholder="E-Mail" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regPwd">Passwort: </label>
				<div class="col">
					<input type="password" name="regPwd" class="form-control" id="regPwd" placeholder="Passwort" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="regPwdWh">Passwort wiederholen: </label>
				<div class="col">
					<input type="password" name="regPwdWh" class="form-control" id="regPwdWh" placeholder="Passwort wiederholen" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-10">
					<button id="regSubmit" type="submit" class="btn btn-primary">Registrieren</button>
				</div>
			</div>
		</form>
	</div>
</main>

<?php }
