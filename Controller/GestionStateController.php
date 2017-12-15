<?php namespace Controller;

use Model\State as State;
use DAOS\StateDAO as StateDAO;

class GestionStateController extends GestionController implements IGestion {

  private $stateDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado');
    try {
      $this->stateDAO = StateDAO::getInstance();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Error: Ocurrio un problema al conectar con la Base de Datos";
    } finally {
      parent::__construct();
      if (isset($msj) && isset($alert)) {
        $this->Alert($msj, $alert);
        die();
      }
    }
  }

  public function Index() {}

  public function Submit() {
    require_once 'AdminViews/SubmitState.php';
  }

  public function SubmitState($description = null) {
    if (isset($description)) {
      $state = new State($description);
      try {
        $state = $this->stateDAO->Insert($state);
        if (isset($state)) {
          $alert = "green";
          $msj = "Estado añadido correctamente: ".$state->getState();
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1062') { //Entrada duplicada
          $msj = "Ya existe el Estado";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al agregar el Estado";
        $this->Alert($msj, $alert);
      }
    }
    $this->Submit();
  }

  public function Update($id_state = null) {
    try {
      $list = $this->stateDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer los Estados";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/UpdateState.php';
  }

  public function UpdateState($id_state = null, $description = null) {
    if (isset($id_state) && isset($description)) {
      $state = new State($description);
      $state->setId($id_state);
      try {
          $state = $this->stateDAO->Update($state);
          if (isset($state)) {
            $alert = "green";
            $msj = "Estado modificado correctamente: ".$state->getState();
            $this->Alert($msj, $alert);
          } else {
            throw new \Exception("", 1);
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al modificar el Estado";
        $this->Alert($msj, $alert);
      }
    }
    if (isset($state)) {
      $id_state = $state->getId();
    } else {
      $id_state = null;
    }
    $this->Update($id_state);
  }

  public function Delete() {
    try {
      $list = $this->stateDAO->SelectAll();
    } catch (\Exception $e) {
      $alert = "red";
      $msj = "Ocurrio un problema al traer los Estados";
      $this->Alert($msj, $alert);
      $list = array();
    }
    require_once 'AdminViews/DeleteState.php';
  }

  public function DeleteState($description = null, $id_state = null) {
    if (isset($description) && isset($id_state)) {
      try {
        if ($this->stateDAO->DeleteById($id_state)) {
          $alert = "green";
          $msj = "Estado eliminado: ".$description." (id ".$id_state.")";
          $this->Alert($msj, $alert);
        } else {
          throw new \Exception("", 1);
        }
      } catch (\PDOException $e) {
        $error = $e->errorInfo;
        $alert = "yellow";
        if ($error[1] == '1451') {
          $msj = "No se pudo eliminar, hay Ordenes en este Estado";
        } else {
          $msj = "Ocurrio un problema con la Base de Datos: error ".$error[1];
        }
        $this->Alert($msj, $alert);
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = "Ocurrio un problema al eliminar el Estado";
        $this->Alert($msj, $alert);
      }
    }
    $this->Delete();
  }
} ?>
