<?php
class users {
	private $conn;
	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $user_role;
	public $timestamp;

	public function __construct($db) {
		$this->conn = $db;
	}

	public function readAll() {
		$sql = "SELECT * FROM users ORDER BY id ASC";
		$result = $this->conn->query($sql);
		return $result;
	}

	public function readOne() {
		$sql = "SELECT * FROM users WHERE id = " . $this->id;
		$result = $this->conn->query($sql);
		$row = $result->fecth_array();
		$this->firstname = $row['firstname'];
		$this->lastname = $row['lastname'];
		$this->email = $row['email'];
		$this->user_role = $row['user_role'];
	}

	public function create() {
		$this->getTimestamp();
		$sql = "INSERT INTO users(firstname, lastname, email, user_role, created_at) VALUES (
			'" . $this->firstname . "',
			'" . $this->lastname . "',
			'" . $this->email . "',
			'" . $this->user_role . "',
			'" . $this->timestamp . "'
		)";
		if ($this->conn->query($sql)) {
			return true;
		} else {
			return false;
		}
	}

	public function getTimestamp() { date_default_timezone_set('Asia/Bangkok'); $this->timestamp = date('Y-m-d H:i:s'); }

	public function update() {
		$sql = "UPDATE users SET 
		 						firstname = '" . $this->firstname . "',
								lastname = '" . $this->lastname . "',
								email = '" . $this->email . "',
								user_role = '" .$this->user_role ."',
								WHERE id = '" . $this->id . "'";
		
		if ($this->conn->query($sql)) {
			return true;
		} else {
			return false;
		}
	}

	public function deledte() {
		$sql = "DELETE FROM users WHERE id = '" . $this->id . "'";
		if ($this->conn->query($sql)) {
			return true;
		} else {
			return false;
		}
	}
}
?>