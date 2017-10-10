<?php namespace Model;

class Beer {
	private $id_beer;
	private $name;
	private $description;
	private $price;
	private $image;
	private $ibu;
	private $srm;
	private $graduation;

	public function __construct($name, $description, $price, $ibu, $srm, $graduation, $image = "") {
		$this->setName($name);
		$this->setDescription($description);
		$this->setPrice($price);
		$this->setImage($image);
		$this->setIbu($ibu);
		$this->setSrm($srm);
		$this->setGraduation($graduation);
	}

	public function getId() {
		return $this->id_beer;
	}

	public function getName() {
		return $this->name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getImage() {
		return $this->image;
	}

	public function getIbu() {
		return $this->ibu;
	}

	public function getSrm() {
		return $this->srm;
	}

	public function getGraduation() {
		return $this->graduation;
	}

	public function setId($value) {
		$this->id_beer = $value;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function setDescription($value) {
		$this->description = $value;
	}

	public function setPrice($value) {
		$this->price = $value;
	}

	public function setImage($value) {
		$this->image = $value;
	}

	public function setIbu($value) {
		$this->ibu = $value;
	}

	public function setSrm($value) {
		$this->srm = $value;
	}

	public function setGraduation($value) {
		$this->graduation = $value;
	}
} ?>
