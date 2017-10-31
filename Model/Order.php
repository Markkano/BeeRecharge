<?php namespace Model;

class Order {
	private $order_number;
	private $order_date;
	private $state;
	private $client;
	private $subsidiary;
	private $orderLines;
	// TODO: private $send;

	public function __construct($order_date, $state, $client, $subsidiary) {
		$this->setOrderDate($order_date);
		$this->setState($state);
		$this->setClient($client);
		$this->setSubsidiary($subsidiary);
	}

	public function getOrderNumber() {
		return $this->order_number;
	}

	public function setOrderNumber($value) {
		$this->order_number = $value;
	}

	public function getOrderDate() {
		return $this->order_date;
	}

	public function setOrderDate($value) {
		$this->order_date = $value;
	}

	public function getState() {
		return $this->state;
	}

	public function setState($value) {
		$this->state = $value;
	}

	public function getClient() {
		return $this->client;
	}

	public function setClient($value) {
		$this->client = $value;
	}

	public function getSubsidiary() {
		return $this->subsidiary;
	}

	public function setSubsidiary($value) {
		$this->subsidiary = $value;
	}

	public function getTotal() {
		return 0;
	}

	public function NewOrderLine($orderLine) {

	}
} ?>
