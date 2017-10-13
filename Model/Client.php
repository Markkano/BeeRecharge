<?php namespace Model;

class Client extends Person	{
	private $id_person;
	private $account;

	public function __construct ($name, $surname, $dni, $address, $phone, $account = null)	{
		parent::__construct($name, $surname, $dni, $address, $phone);
		$this->setAccount($account);
	}

	public function setId($value) {
		$this->id_person = $value;
	}

	public function getId()	{
		return $this->id_person;
	}

	public function setAccount($value) {
		$this->account = $value;
	}

	public function getAccount() {
		return $this->account;
	}
} ?>
