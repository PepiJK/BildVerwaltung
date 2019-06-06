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

			$sql = "INSERT INTO `users` (`username`, `vorname`, `nachname`, `email`, `password`, `is_admin`) VALUES (?, ?, ?, ?, ?, 1)";
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

			$sql = "INSERT INTO `users` (`username`, `vorname`, `nachname`, `email`, `password`, `is_admin`) VALUES (?, ?, ?, ?, ?, 0)";
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

			$sql = "SELECT * FROM users WHERE username = '$dbUser'";
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

	// get specific user data wich matches exisiting cookie
	public function getUserCookie() {
		if($this->connection) {
			$sql = "SELECT * FROM users";
			$result = $this->connection->query($sql);
			$data = array();
			
			while ($row = $result->fetch_object()) {
				if (isset($_COOKIE[$row->username])) {
					return $row;
				}
			} 
			return false;
		}
	}
	
}
