<?php namespace Model;

class Role {
	private $id_role;
	private $rolename;
	private $description;

	public function __construct ($rolename, $description)	{
		$this->setRolename($rolename);
		$this->setDescription($description);
	}

	public function setId($id) {
		$this->id_role = $id;
	}

	public function getId()	{
		return $this->id_role;
	}

	public function setRolename($rolename) {
		$this->rolename = $rolename;
	}

	public function getRolename()	{
		return $this->rolename;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}
} ?>
