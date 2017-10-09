<?php namespace Model;

class OrderLine {
	private $id_orderLine;
	private $amount;
	private $price;
	private $beer;
	private $packaging;
	private $order;

	public function __construct($amount, $price, $beer, $packaging, $order)	{
		$this->amount = $amount;
		$this->price = $price;
		$this->beer = $beer;
		$this->packaging = $packaging;
		$this->order = $order;
	}

	public function getId(){
		return $this->id_orderLine;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function getPrice(){
		return $this->price;
	}

	public function getBeer(){
		return $this->beer;
	}

	public function getPackaging(){
		return $this->packaging;
	}

	public function getOrder(){
		return $this->order;
	}

	public function setId($value){
		$this->id_orderLine = $value;
	}

	public function setAmount($value){
		$this->amount = $value;
	}

	public function setPrice($value){
		$this->price = $value;
	}

	public function setBeer($value){
		$this->beer = $value;
	}

	public function setPackaging($value){
		$this->packaging = $value;
	}

	public function setOrder($value){
		$this->order = $value;
	}
} ?>
