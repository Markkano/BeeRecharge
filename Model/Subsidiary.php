<?php namespace Model;

class Subsidiary {
	private $id_subsidiary;
	private $address;
	private $phone;
	private $lat;
	private $lon;

	public function __construct($address, $phone, $lat = 0.0, $lon = 0.0)	{
		$this->setAddress($address);
		$this->setPhone($phone);
	}

	public function getId() {
		return $this->id_subsidiary;
	}

	public function setId($value) {
		$this->id_subsidiary = $value;
	}

	public function getAddress() {
		return $this->address;
	}

	public function setAddress($value) {
		$this->address = $value;
	}

	public function getPhone() {
		return $this->phone;
	}

	public function setPhone($value) {
		$this->phone = $value;
	}

	public function getLat() {
		return $this->lat;
	}

	public function setLat($value) {
		$this->lat = $value;
	}

	public function getLon() {
		return $this->lon;
	}

	public function setLon($value) {
		$this->lon = $value;
	}
} ?>
