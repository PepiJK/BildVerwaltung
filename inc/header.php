<?php

	// try login process via existing cookie when not allready loged in
	if(!isset($_SESSION['loggedin'])) {
		//check all users in database who match cookie name
		$query = $db->getUserCookie();

		// if username matches existing cookie name -> create user object and log user in
		if($query) {
			$user = new USER($query->username, $query->vorname, $query->nachname, $query->email, $query->password, $query->is_admin);
			$user->loginUser(true);
		}
	}
	

	// login process via form submit
	if (isset($_POST['username']) && isset($_POST['password'])) {
		// query the data in database and return it on success
		$query = $db->getUser($_POST['username'], $_POST['password']);

		// if query was successfull -> create user object and log user in
		if($query) {
			// loginckeck -> determines if cookie will be created or not
			if(isset($_POST['loginCheck'])) { $loginCheck = true; } else { $loginCheck = false; }
			$user = new USER($query->username, $query->vorname, $query->nachname, $query->email, $query->password, $query->is_admin);
			$user->loginUser($loginCheck);
		} else {
			$errorMsg = '<ul class="navbar-nav"> <li class="nav-item text-center text-white bg-danger rounded mr-3 p-2">Anmeldung Fehlgeschlagen!</li></ul>';
		}
	}
	
	$navigationFile = simplexml_load_file('./config/navigation.xml');

	// anonymous user
	if (!isset($_SESSION['loggedin'])) {
		$navigation = (array) $navigationFile->anonym;
	}

	// loggedin user
	else if (isset($_SESSION['loggedin']) && !$_SESSION['admin']) {
		$navigation = (array) $navigationFile->registriert;
	}

	// admin user
	else if (isset($_SESSION['loggedin']) && $_SESSION['admin']) {
		$navigation = (array) $navigationFile->admin;
	}

	// logout process
	if(isset($_GET['logout'])) {
		$user->logoutUser();
	}
?>

<!-- HEADER -->
<header>

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark">

		<!-- BRAND -->
		<a class="navbar-brand" href="./index.php?url=home">
			BildVerwaltung
		</a>

		<!-- NAVBAR TOGGLER -->
		<button class="navbar-toggler btn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- MEMNU LINKS -->
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">

				<!-- Output every nav-item from the navigation.xml -->
				<?php foreach ($navigation as $item => $element) {
					// omit the last item because of login (Array-Element is either 0 or 1)
					if ($item === array_key_last($navigation)) { break; } ?>

				<li class="nav-item <?php if ($_GET['url'] == $item) echo 'active border-bottom border-white' ?>">
					<a class="nav-link" href="index.php?url=<?php echo $item ?>"><?php echo $element ?></a>
				</li>

				<?php } ?>

			</ul>

			<!-- Check if the user is either able to login or to logout-->
			<?php if ($navigation['login']) { 
				if (isset($errorMsg)) echo $errorMsg ?>

			<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-sign-in-alt text-white"></i>
			</span>

			<form class="dropdown-menu dropdown-menu-right p-4" action="./index.php?url=<?php echo $_GET['url'] ?>" method="post">
				<div class="form-group">
					<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
				</div>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" name="loginCheck" id="loginCheck">
					<label class="form-check-label" for="loginCheck"> Eingeloggt bleiben </label>
				</div>
				<div class="text-center mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<button type="button" class="btn btn-secondary" onclick="self.location='./index.php?url=forgotlogin'">Login vergessen</button>
				</div>
				<hr>
				<div class="text-center">
					<button type="button" class="btn btn-primary" onclick="self.location='./index.php?url=userregistration'">Registrieren</button>
				</div>
			</form>

			<!-- LOGOUT -->
			<?php } else { ?>

			<ul class="navbar-nav">
				<li class="nav-item text-center mr-3 text-light">
					eingeloggt als user <?php echo $user->username ?>
				</li>
			</ul>

			<a href="./index.php?logout=true&url=<?php echo $_GET['url'] ?>">
				<i class='fas fa-sign-out-alt text-white'></i>
			</a>

			<?php } ?>

		</div>
	</nav>
</header>
