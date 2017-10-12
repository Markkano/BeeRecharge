<?php namespace Model;

class Account	{
	private $id_account;
	private $username;
	private $email;
	private $password;
	private $image;

	public function __construct ($username, $email, $password, $image) {
		$this->setUsername($username);
		$this->setEmail($email);
		$this->setPassword($password);
		$this->setImage($image);
	}

	public function setId($value) {
		$this->id_account = $value;
	}

	public function getId()	{
		return $this->id_account;
	}

	public function setEmail($value) {
		$this->email = $value;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setUsername($value) {
		$this->username = $value;
	}

	public function getUsername()	{
		return $this->username;
	}

	public function setPassword($value) {
		$this->password = $value;
	}

	public function getPassword()	{
		return $this->password;
	}

	public function setImage($value) 	{
		$this->image = $value;
	}

	public function getImage() {
		return $this->image;
	}
} ?>
