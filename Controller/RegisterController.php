<?php namespace Controller;
 use DAOS\AccountDAO as AccountDAO;
 use DAOS\ClientDAO as ClientDAO;
 use Model\Client as Client;
 use Model\Account as Account;

 class RegisterController {

	private $AccountDAO;
	private $ClientDAO;

  public function __construct() {
    $this->AccountDAO = new AccountDAO();
    $this->ClientDAO = new ClientDAO();
  }

	public function Index() {
		require 'Views/register.php';
	}

	public function insertClient($username, $email, $password, $name, $surname, $dni, $address, $phone) {
    /*
    Creo la cuenta, creo el cliente y los inserto a la base de datos.
    */
    $account = new Account($username, $email, $password, "");
		$client = new Client($name, $surname, $dni, $address, $phone, $account);
		$this->ClientDAO->Insert($client);
	}
} ?>
