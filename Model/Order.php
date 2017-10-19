<?php namespace Model;

class Order {
	private $order_number;
	private $order_date;
	private $state;
	private $client;
	private $subsidiary;

	public function __construct($order_date, $state, $client, $subsidiary = null) {
		$this->setOrderDate($order_date);
		$this->setState($state);
		$this->setSubsidiary($subsidiary);

	}

	public function getOrderNumber() {
		return $this->order_number;
	}

	public function getOrderDate() {
		return $this->order_date;
	}

	public function getState() {
		return $this->state;
	}

	public function getClient() {
		return $this->client;
	}

	public function getSubsidiary() {
		return $this->subsidiary;
	}

	public function setSubsidiary($value) {
		$this->subsidiary = $value;
	}

	public function setOrderNumber($value) {
		$this->order_number = $value;
	}

	public function setOrderDate($value) {
		$this->order_date = $value;
	}

	public function setState($value) {
		$this->state = $value;
	}

	public function setClient($value) {
		$this->client = $value;
	}
} ?>
