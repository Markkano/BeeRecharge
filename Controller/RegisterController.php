<?php namespace Controller;
 use DAOS\AccountDAO as AccountDAO;
 use DAOS\ClientDAO as ClientDAO;
 use Model\Client as Client;
 use Model\Account as Account;

 class RegisterController {

	private $AccountDAO;
	private $ClientDAO;

  public function __construct() {
    $this->AccountDAO = AccountDAO::getInstance();
    $this->ClientDAO = ClientDAO::getInstance();
  }

	public function Index($msj = null, $alert = null) {
		require 'Views/register.php';
	}

	public function insertClient($username, $email, $password, $name, $surname, $dni, $address, $phone) {
    /*
    Creo la cuenta, creo el cliente y los inserto a la base de datos.
    */
    if (
      isset($username) && !strcmp($username, "") == 0 &&
      isset($email) && !strcmp($email, "") == 0 &&
      isset($password) && !strcmp($password, "") == 0 &&
      isset($name) && !strcmp($name, "") == 0 &&
      isset($surname) && !strcmp($surname, "") == 0 &&
      isset($dni) && !strcmp($dni, "") == 0 &&
      isset($address) && !strcmp($address, "") == 0 &&
      isset($phone) && !strcmp($phone, "") == 0
    ) {
      $account = new Account($username, $email, $password, "");
  		$client = new Client($name, $surname, $dni, $address, $phone, $account);
  		$error = $this->ClientDAO->Insert($client);
      if (!isset($error)) {
        $_SESSION['client'] = $client;
        header('location: /listaCervezas');
      } else {
        # TODO: Ocurrio un problema
      }
    } else {
      $msj = "Compruebe los datos ingresados";
      $alert = "red";
      $this->Index($msj, $alert);
    }
	}
} ?>
