<?php namespace Controller;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;
use Controller\GestionController as GestionController;

class gestionPackagingController extends GestionController {

  public function __construct() {
    self::$roles = array('Admin', 'Empleado');
    parent::__construct();
  }

  public function Index() {}

  public function SubmitPackaging($description = null, $capacity = null, $factor = null) {
    if (isset($description)) {
      $packagingDAO = new PackagingDAO();
      $packaging = new Packaging($description, $capacity, $factor);

      $error = $packagingDAO->Insert($packaging);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Envase añadido correctamente: ".$packaging->getDescription();
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema: ".$error;
      }
    }
    require 'AdminViews/SubmitPackaging.php';
  }

  public function UpdatePackaging($id_packaging = null, $description = null, $capacity = null, $factor = null) {
    $packagingDAO = new PackagingDAO();
    if (isset($description)) {
      $packaging = new Packaging($description, $capacity, $factor);
      $packaging->setId($id_packaging);
      $error = $packagingDAO->Update($packaging);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Envase modificado correctamente: ".$packaging->getDescription();
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema: ".$error;
      }
    }
    $list = $packagingDAO->SelectAll();
    require 'AdminViews/UpdatePackaging.php';
  }

  public function DeletePackaging($description = null, $id_packaging = null) {
    $packagingDAO = new PackagingDAO();
    if (isset($description)) {
      $error = $packagingDAO->DeleteById($id_packaging);
      if (!isset($error)) {
        $alert = "green";
        $msj = "Envase eliminado: ".$description." (id ".$id_packaging.")";
      } else {
        $alert = "yellow";
        $msj = "Ocurrio un problema: ".$error;
      }
    }
    $list = $packagingDAO->SelectAll();
    require 'AdminViews/DeletePackaging.php';
  }
}
