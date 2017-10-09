<?php namespace Model;

class Staff extends Person {
	private $id_staff;
	private $salary;
	private $account;
	private $role;

	public function __construct ($name, $surname, $dni, $address, $phone, $salary) {
		parent::__construct($name, $surname, $dni, $address, $phone);
		$this->setSalary($salary);
	}

	public function setId($id_staff) {
		$this->id_staff = $id_staff;
	}
	
	public function getId()	{
		return $this->id_staff;
	}

	public function setSalary($salary) {
		$this->salary = $salary;
	}

	public function getSalary() {
		return $this->salary;
	}

	public function setAccount(Account $account) {
		$this->account = new Account($account);
	}

	public function getAccount() {
		return $this->account;
	}

	public function setRole(Role $role)	{
		$this->role = new Role($role);
	}

	public function getRole()	{
		return $this->role;
	}
} ?>
