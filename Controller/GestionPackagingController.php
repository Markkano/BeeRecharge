<?php namespace Controller;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;
use Controller\GestionController as GestionController;

class gestionPackagingController extends GestionController implements IGestion {

  private $packagingDAO;

  public function __construct() {
    self::$roles = array('Admin', 'Empleado');
    $this->packagingDAO = PackagingDAO::getInstance();
    parent::__construct();
  }

  public function Index() {}

  public function Submit($description = null, $capacity = null, $factor = null) {
    if (isset($description)) {
      $packaging = new Packaging($description, $capacity, $factor);
      try {
        $packaging = $this->packagingDAO->Insert($packaging);
        if (isset($packaging)) {
          $alert = "green";
          $msj = "Envase añadido correctamente: ".$packaging->getDescription();
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    require_once 'AdminViews/SubmitPackaging.php';
  }

  public function Update($id_packaging = null, $description = null, $capacity = null, $factor = null) {
    if (isset($description)) {
      $packaging = new Packaging($description, $capacity, $factor);
      $packaging->setId($id_packaging);
      try {
          $packaging = $this->packagingDAO->Update($packaging);
          if (isset($packaging)) {
            $alert = "green";
            $msj = "Envase modificado correctamente: ".$packaging->getDescription();
          } else {
            $alert = "yellow";
            $msj = "Ocurrio un problema";
          }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/UpdatePackaging.php';
  }

  public function Delete($description = null, $id_packaging = null) {
    if (isset($description) && isset($id_packaging)) {
      try {
        if ($this->packagingDAO->DeleteById($id_packaging)) {
          $alert = "green";
          $msj = "Envase eliminado: ".$description." (id ".$id_packaging.")";
        } else {
          $alert = "yellow";
          $msj = "Ocurrio un problema";
        }
      } catch (\Exception $e) {
        $alert = "yellow";
        $msj = $e->getMessage();
      }
    }
    $list = $this->packagingDAO->SelectAll();
    require_once 'AdminViews/DeletePackaging.php';
  }
}
