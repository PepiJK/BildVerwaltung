<?php

class USER {

	public $username = null;
	public $password = null;
	public $vorname = null;
	public $email = null;
	public $nachname = null;
	public $is_admin = null;

	public function __construct($username, $vorname, $nachname, $email, $password, $is_admin) {
		$this->username = $username;
		$this->vorname = $vorname;
		$this->nachname = $nachname;
		$this->password = $password;
		$this->email = $email;
		$this->is_admin = $is_admin;
	}

	// set session variables, create cookie and redirect
	public function loginUser($loginCheck) {
		$_SESSION['loggedin'] = true;
		$_SESSION['username'] =  $this->username;
		$_SESSION['vorname'] = $this->vorname;
		$_SESSION['nachname'] = $this->nachname;
		$_SESSION['email'] = $this->email;
		$_SESSION['password'] = $this->password;
		// see if user is an admin
		if ($this->is_admin) {
			$_SESSION['admin'] = true;
		} else {
			$_SESSION['admin'] = false;
		}
		// check if eingeloggt bleiben was checked when logging in and create cookie
		if ($loginCheck) { 
			$cookie_name = $this->username;
			// check if user is admin and set cookie value according to it
			if ($this->is_admin) {
				$cookie_value = 1;
			} else {
				$cookie_value = 0;
			}
			// cookie lasts 1 day till it expires (24h * 60min * 60sec = 86400)
			setcookie($cookie_name, $cookie_value, time() + (86400));
		}
		
		// redirect
		if ($_GET['url'] == 'userregistration' || $_GET['url'] == 'forgotlogin') { 
			header('Location:index.php?link=home'); 
		}
	}

	// delete cookie and session and redirect
	public function logoutUser() {
		setcookie($this->username, true, time() - 3600); 
		session_unset();
		session_destroy();
		
		if($_GET['url'] == 'userverwaltung' || $_GET['url'] == 'bildverwaltung' || $_GET['url'] == 'profilverwaltung') {
			header('Location:index.php?url=home');
		} else {
			header('Location:index.php?url=' . $_GET['url']);
		}
	}

	// update user vorname, nachname, email
	public function updateUserData($dbVor, $dbNach, $dbEmail) {
		$this->vorname = $dbVor;
		$this->nachname = $dbNach;
		$this->email = $dbEmail;

		$_SESSION['vorname'] = $dbVor;
		$_SESSION['nachname'] = $dbNach;
		$_SESSION['email'] = $dbEmail;
	}

	// safe hashed password
	public function updateUserPassword($dbPwd) {
		$this->password = $dbPwd;
		
		$_SESSION['password'] = $dbPwd;
	}

}
