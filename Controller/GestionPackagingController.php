<?php namespace Controller;

use DAOS\PackagingDAO as PackagingDAO;
use Model\Packaging as Packaging;

class gestionPackagingController {

  public function __construct() {
    require 'AdminViews/GestionLobby.php';
  }

  public function Index() {}

  public function SubmitPackaging($description = null, $capacity = null, $factor = null) {
    if (isset($description)) {
      $packagingDAO = new PackagingDAO();
      $packaging = new Packaging($description, $capacity, $factor);
      #$packagingDAO->Insert($packaging);
      $alert = "green";
      $msj = "Envase añadido correctamente: ".$description;
    }
    require 'AdminViews/SubmitPackaging.php';
  }

  public function UpdatePackaging($description = null, $capacity = null, $factor = null) {

    $packagingDAO = new PackagingDAO();
    $list = $packagingDAO->SelectAll();
    require 'AdminViews/UpdatePackaging.php';
  }

  public function DeletePackaging($description = null, $id_packaging = null) {
      if (isset($description)) {
        $alert = "green";
        $msj = "Envase eliminado: ".$description." (id ".$id_packaging.")";
      }
    $packagingDAO = new PackagingDAO();
    $list = $packagingDAO->SelectAll();
    require 'AdminViews/DeletePackaging.php';
  }
}
