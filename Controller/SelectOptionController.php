<?php namespace Controller;

use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;
use DAOS\StaffDAO as StaffDAO;
use Model\Staff as Staff;
use DAOS\ClientDAO as ClientDAO;
use Model\Client as Client;
use DAOS\RoleDAO as RoleDAO;
use Model\Role as Role;

class SelectOptionController {

  private $accountDAO;
  private $staffDAO;
  private $clientDAO;

  public function __construct() {
    $this->accountDAO = AccountDAO::getInstance();
    $this->staffDAO = StaffDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
  }

  public function Index() {
    require_once 'Views/SelectOption.php';
  }

  public function Select($value = null) {
    if (!isset($value)) {
      $this->Index();
    } else {
      switch ($value) {
        case 'Client':
        header('location: /'.BASE_URL.'Lobby');
        break;

        case 'Staff':
        header('location: /'.BASE_URL.'Gestion');
        break;
      }
    }
  }
}
