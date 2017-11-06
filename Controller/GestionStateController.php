<?php namespace Controller;

use Model\State as State;
use DAOS\StateDAO as StateDAO;

class GestionStateController extends GestionController implements IGestion {

  private $stateDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado');
    $this->stateDAO = StateDAO::getInstance();
    parent::__construct();
  }

  public function Index() {}

  public function Submit($description = null) {
    if (isset($description)) {
      $state = new State($description);
      try {
        $state = $this->stateDAO->Insert($state);
        if (isset($state)) {
          $alert = "green";
          $msj = "Estado añadido correctamente: ".$state->getState();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/SubmitState.php';
  }

  public function Update($id_state = null, $description = null) {
    if (isset($id_state) && isset($description)) {
      $state = new State($description);
      $state->setId($id_state);
      try {
          $state = $this->stateDAO->Update($state);
          if (isset($state)) {
            $alert = "green";
            $msj = "Estado modificado correctamente: ".$state->getState();
          } else {
            $alert = "yellow";
            $msj = "Ocurrio un problema";
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->stateDAO->SelectAll();
    require_once 'AdminViews/UpdateState.php';
  }

  public function Delete($description = null, $id_state = null) {
    if (isset($description) && isset($id_state)) {
      try {
        if ($this->stateDAO->DeleteById($id_state)) {
          $alert = "green";
          $msj = "Estado eliminado: ".$description." (id ".$id_state.")";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        if ($e->getCode() == 1451) {
          $msj = "No se ha podido eliminar. Hay ordenes en este Estado";
        } else {
          $msj = $e->getMessage();
        }
      }
    }
    $list = $this->stateDAO->SelectAll();
    require_once 'AdminViews/DeleteState.php';
  }
} ?>
