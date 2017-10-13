<?php namespace Model;

class Packaging {
	private $id_packaging;
	private $description;
	private $capacity;
	private $factor;

	public function __construct($description, $capacity, $factor)	{
		$this->setDescription($description);
		$this->setCapacity($capacity);
		$this->setFactor($factor);
	}

	public function getId(){
		return $this->id_packaging;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getCapacity(){
		return $this->capacity;
	}

	public function getFactor(){
		return $this->factor;;
	}

	public function setId($value){
		$this->id_packaging = $value;
	}

	public function setDescription($value){
		$this->description = $value;
	}

	public function setCapacity($value){
		$this->capacity = $value;
	}

	public function setFactor($value){
		$this->factor = $value;
	}

	public function toJson() {
    return [
			'id_packaging' => $this->id_packaging,
			'description' => $this->description,
			'capacity' => $this->capacity,
			'factor' => $this->factor
		];
  }
} ?>
