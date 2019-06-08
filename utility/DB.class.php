<?php 

include "./config/dbaccess.php";

class DB {
	
	private $connection = null;

	public function __construct() {
		$this->connection = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
		$this->saveUserAdmin();
	}

	// create an administrator in database (for test usage only!)
	public function saveUserAdmin() {
		if($this->connection) {
			$dbUser = "admin";
			$dbVor = "adminVorname";
			$dbNach = "adminNachname";
			$dbEmail = "adminEmail";
			$dbPwd = password_hash("12345", PASSWORD_DEFAULT);

			$sql = "INSERT INTO `users` (`username`, `vorname`, `nachname`, `email`, `password`, `is_admin`, `status`) VALUES (?, ?, ?, ?, ?, 1, 1)";
			$statement = $this->connection->prepare($sql);
			$statement->bind_param("sssss", $dbUser, $dbVor, $dbNach, $dbEmail, $dbPwd);
			$statement->execute();
		}
	}

	// save user in database 
	public function saveUser($user, $vor, $nach, $email, $pwd) {
		if($this->connection) {
			$dbUser = $this->connection->real_escape_string($user);
			$dbVor = $this->connection->real_escape_string($vor);
			$dbNach = $this->connection->real_escape_string($nach);
			$dbEmail = $this->connection->real_escape_string($email);
			$dbPwd = password_hash($this->connection->real_escape_string($pwd), PASSWORD_DEFAULT);

			$sql = "INSERT INTO `users` (`username`, `vorname`, `nachname`, `email`, `password`, `is_admin`, `status`) VALUES (?, ?, ?, ?, ?, 0, 1)";
			$statement = $this->connection->prepare($sql);
			$statement->bind_param("sssss", $dbUser, $dbVor, $dbNach, $dbEmail, $dbPwd);

			// return true on successfully storeing new user in db, return error messages, errorcode, etc on false
			if($statement->execute()){
				return true;
			} else {
				return $statement;
			}
		}
	}
	
	// get specific user data where username and password match from database
	public function getUser($user, $pwd) {
		if($this->connection) {
			$dbUser = $this->connection->real_escape_string($user);
			$dbPwd = $this->connection->real_escape_string($pwd);

			$sql = "SELECT * FROM users WHERE username = '$dbUser' AND status = '1'";
			$result = $this->connection->query($sql);

			// check query results
			if ($result && $result->num_rows) {
				// save query result in object
				$queryUser = $result->fetch_object();
				// check pwd
				if (password_verify($dbPwd, $queryUser->password)) {
					return $queryUser;
				}
			}
			return false;
		}
	}

	// get every user in database except admin
	public function getAllUsers() {
		if($this->connection) {
			$sql = "SELECT * FROM users WHERE is_admin = '0'";
			$result = $this->connection->query($sql);
			$data = array();
			
			while ($row = $result->fetch_object()) {
				array_push($data, $row);
			}
			return $data;
		}
	}

	// get specific user data wich matches exisiting cookie
	public function getUserCookie() {
		if($this->connection) {
			$sql = "SELECT * FROM users WHERE status = '1'";
			$result = $this->connection->query($sql);
			
			while ($row = $result->fetch_object()) {
				if (isset($_COOKIE[$row->username])) {
					return $row;
				}
			} 
			return false;
		}
	}

	// change User Data from form input (profilverwaltung)
	public function changeUserData($user, $vor, $nach, $email) {
		if($this->connection) {
			$dbUser = $user->username;
			$dbVor = $this->connection->real_escape_string($vor);
			$dbNach = $this->connection->real_escape_string($nach);
			$dbEmail = $this->connection->real_escape_string($email);

			$sql = "UPDATE users SET vorname='$dbVor', nachname='$dbNach', email='$dbEmail' WHERE username='$dbUser'";

			if ($this->connection->query($sql)) {
				$user->updateUserData($dbVor, $dbNach, $dbEmail);
				return true;
			}
			return false;
		}
	}

	// change User Password
	public function changeUserPassword($user, $newPwd, $updateUser) {
		if($this->connection) {
			$dbPwd = password_hash($this->connection->real_escape_string($newPwd), PASSWORD_DEFAULT);
			if($updateUser) {
				$dbUser = $user->username;
			} else {
				$dbUser = $user;
			}
			
			$sql = "UPDATE users SET password='$dbPwd' WHERE username='$dbUser'";

			if ($this->connection->query($sql)) {
				// change password of the currently loged in user (used in profilverwaltung, not used in userverwaltung)
				if($updateUser) {
					$user->updateUserPassword($dbPwd);
				}
				return true;
			}
			return false;
		}
	}

	// delete specific user from database
	public function deleteUser($dbUser) {
		if($this->connection) {
			$sql = "DELETE FROM users WHERE username='$dbUser'";
			
			if ($this->connection->query($sql)) {
				return true;
			}
			return false;
		}
	}

	// change status
	public function changeStatus($dbStatus, $dbUser) {
		if($this->connection) {
			$sql = "UPDATE users SET status='$dbStatus' WHERE username='$dbUser'";

			if ($this->connection->query($sql)) {
				return true;
			}
			return false;
		}
	}

	public function __destruct() {
		$this->connection->close();
	}
	
}
