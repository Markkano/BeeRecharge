<?php namespace Model;

abstract class Person	{
	protected $idperson;
	protected $name;
	protected $surname;
	protected $dni;
	protected $address;
	protected $phone;

	public function __construct($name, $surname, $dni, $address, $phone) {
		$this->setName($name);
		$this->setSurname($surname);
		$this->setDni($dni);
		$this->setAddress($address);
		$this->setPhone($phone);
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getName()	{
		return $this->name;
	}

	public function setSurname($value) {
		$this->surname = $value;
	}

	public function getSurname() {
		return $this->surname;
	}

	public function setDni($value) {
		$this->dni = $value;
	}

	public function getDni() {
		return $this->dni;
	}

	public function setAddress($value) {
		$this->address = $value;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setPhone($value) {
		$this->phone = $value;
	}

	public function getPhone() {
		return $this->phone;
	}
} ?>
