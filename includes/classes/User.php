<?php
class User
{

	private $con;
	private $username;

	public function __construct($con, $username)
	{
		$this->con = $con;
		$this->username = $username;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getEmail()
	{
		$query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['email'];
	}

	public function getcheckuser(){
		$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
		if (mysqli_num_rows($query) != 0) {
			return true;
		}
	}


	public function getUsernameemail()
	{
		$query = mysqli_query($this->con, "SELECT username FROM users WHERE username='$this->username' OR email ='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['username'];
	}



	public function getFirstAndLastName()
	{
		$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name'  FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['name'];
	}

	public function getUserId()
	{
		$query = mysqli_query($this->con, "SELECT id FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['id'];
	}

	public function getuserCoverimage(){
		$query = mysqli_query($this->con, "SELECT profilePic FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['profilePic'];
	}

	public function getPoints()
	{
		$query = mysqli_query($this->con, "SELECT points FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['points'];
	}

	public function getUserrole(){
		$query = mysqli_query($this->con, "SELECT mwRole FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['mwRole'];
	}

	public function getUserStatus(){
		$query = mysqli_query($this->con, "SELECT status FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['status'];
	}
}