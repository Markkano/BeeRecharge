<?php namespace Model;

class Client extends Person	{
	private $id_person;
	private $account;

	public function __construct ($name, $surname, $dni, $address, $phone)	{
		parent::__construct($name, $surname, $dni, $address, $phone);
	}

	public function setId($value) {
		$this->id_person = $value;
	}

	public function getId()	{
		return $this->id_person;
	}

	public function setAccount(Account $account) {
		$this->account = new Account($account);
	}

	public function getAccount() {
		return $this->account;
	}
} ?>
