<?php 

// change personal data
if(isset($_POST['changeVor']) && isset($_POST['changeNach']) && isset($_POST['changeEmail'])) {
	$changeData = $db->changeUserData($user, $_POST['changeVor'], $_POST['changeNach'], $_POST['changeEmail']);
	if($changeData) {
		$changeDataSuccess = '<div class="alert alert-success" role="alert">Daten wurden erfolgreich geändert!</div>';
	} else {
		$changeDataSuccess = '<div class="alert alert-danger" role="alert">Daten konnten leider nicht geändert werden!</div>';
	}
}

// change password if old password matches
if(isset($_POST['changePwdOld']) && isset($_POST['changePwdNew'])) {
	if (password_verify($_POST['changePwdOld'], $user->password)) {
		$changePwd = $db->changeUserPassword($user, $_POST['changePwdNew'], true);
		if ($changePwd) {
			$changePwdSuccess = '<div class="alert alert-success" role="alert">Passwort wurde erfolgreich geändert!</div>';
		} else {
			$changePwdSuccess = '<div class="alert alert-danger" role="alert">Passwort konnten leider nicht geändert werden!</div>';
		}
	} else {
		$errorPwdMatch = '<div class="alert alert-danger" role="alert">Altes Passwort stimmt nicht überein</div>';
	}
}

if ($_GET['url'] == 'profilverwaltung') { ?>

<main>
	<div class="container mt-3">
		<h1>Profilverwaltung</h1>

		<h2>Stammdaten ändern</h2>
		<?php if(isset($changeDataSuccess)) echo $changeDataSuccess ?>
		<form action="./index.php?url=profilverwaltung" method="POST" id="changeForm" class="mt-3">
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="changeUser">Username: </label>
				<div class="col">
					<input type="text" name="changeUser" class="form-control" id="changeUser" value="<?php echo $user->username ?>" disabled>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="changeVor">Vorname: </label>
				<div class="col">
					<input type="text" name="changeVor" class="form-control" id="changeVor" value="<?php echo $user->vorname ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="changeNach">Nachname: </label>
				<div class="col">
					<input type="text" name="changeNach" class="form-control" id="changeNach" value="<?php echo $user->nachname ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="changeEmail">E-Mail: </label>
				<div class="col">
					<input type="email" name="changeEmail" class="form-control" id="changeEmail" value="<?php echo $user->email ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-10">
					<button id="changeSubmit" type="submit" class="btn btn-primary">Ändern</button>
				</div>
			</div>
		</form>

		<hr class="mt-5">

		<h2 class="mt-5">Passwort ändern</h2>
		<?php if(isset($changePwdSuccess)) echo $changePwdSuccess; if(isset($errorPwdMatch)) echo $errorPwdMatch ?>
		<form action="./index.php?url=profilverwaltung" method="POST" id="changeForm" class="mt-3">
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="changePwdOld">Altes Passwort: </label>
				<div class="col">
					<input type="password" name="changePwdOld" class="form-control" id="changePwdOld" placeholder="Altes Passwort" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="changePwdNew">Neues Passwort: </label>
				<div class="col">
					<input type="password" name="changePwdNew" class="form-control" id="changePwdNew" placeholder="Neues Passwort" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-lg-10">
					<button id="changeSubmit" type="submit" class="btn btn-primary">Ändern</button>
				</div>
			</div>
		</form>

	</div>
</main>

<?php }
