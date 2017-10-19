<?php namespace Model;

class Staff extends Person {
	private $id_staff;
	private $salary;
	private $account;
	private $role;

	public function __construct ($name, $surname, $dni, $address, $phone, $salary, $account, $role) {
		parent::__construct($name, $surname, $dni, $address, $phone);
		$this->setSalary($salary);
		$this->setAccount($account);
		$this->setRole($role);
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

	public function setAccount($account) {
		$this->account = $account;
	}

	public function getAccount() {
		return $this->account;
	}

	public function setRole($role)	{
		$this->role = $role;
	}

	public function getRole()	{
		return $this->role;
	}

	public function toJson() {
    return [
			'id_staff' => $this->id_staff,
			'name' => $this->name,
			'surname' => $this->surname,
			'dni' => $this->dni,
			'address' => $this->address,
			'phone' => $this->phone,
			'salary' => $this->salary,
			'account' => $this->account->toJson(),
			'role' => $this->role->toJson()
		];
  }
} ?>
