<?php namespace Controller;

use DAOS\ClientDAO as ClientDAO;
use DAOS\StaffDAO as  StaffDAO;
use DAOS\AccountDAO as AccountDAO;
use Model\Account as Account;
use Model\Staff as Staff;
use Model\Client as Client;

class LoginController {

  private $AccountDAO;
  private $StaffDAO;
  private $ClientDAO;

  public function __construct ()
  {
      $this->AccountDAO = AccountDAO::getInstance();
      #$this->StaffDAO = StaffDAO::getInstance();
      #$this->ClientDAO = ClientDAO::getInstance();
  }

  public function Index() {
    require_once 'Views/login.php';
  }

  public function facebookLogin()
  {
    try {
      if(isset($_POST['usuario']))
      {
        $objeto=json_decode($_POST['usuario']);
        $nombre=$objeto->name;
        $apellido = $objeto->surname;
        $username = $nombre.$apellido;
        $email=$objeto->email;
        $password=$objeto->password;
        $image=$objeto->image;

        $usuario = new Account($username,$email,$password,$image);
        $account= $this->AccountDAO->SelectByUsername($username);

        if(isset($account))
        {
            $person= $this->StaffDAO->SelectByAccount($account);
            if(isset($person))
            {
                require_once('location: /gestion');
            }
            else
            {
               require_once('location: /agregarCerveza.php');
            }

        }
        else
        {
            $person=new Client($nombre,$apellido,'','','',$usuario);
            $this->ClientDAO->Insert($person);
        }
        throw new Exception("Error Processing Request", 1);
      }

    } catch (Exception $e) {
      var_dump($e->getMessage());
      require_once 'Views/login.php';
    }
  }

  public function ProcesarLogin($username, $password) {

   $account = $dao->SelectByUsername($username);
    if (isset($account)) {
    	if(strcmp ($account->getUserName() , $username ) == 0 && (strcmp ($account->getPassword() , $password )) == 0) {

        $_SESSION['account'] = $account;
    	  $usuario=$this->Staffdao->SelectByAccount($account);

        if (isset($usuario))
      	{
      		 require_once('location: /gestion');
      	}

      	else
      	{
      		$usuario=$this->ClientDAO->SelectByAccount($account);
      		require_once('location: /listaCervezas');
      	}

      }

    else {
        echo "Credenciales Incorrectas";
      }
    }
     #TODO Credenciales Incorrectas
  }

  public function Logout() {
    unset($_SESSION['account']);
    header('location: /');
  }
} ?>
