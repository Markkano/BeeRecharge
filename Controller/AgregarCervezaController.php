<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
use DAOS\PackagingDAO as PackagingDAO;
class AgregarCervezaController {

  public function Traer($id) {
    $BeerDAO = new BeerDAO();
    $beer = $BeerDAO->SelectByID($id);
    return $beer;
  }

  public function Mostrar($id) {
    $PackagingDAO = new PackagingDAO();
    $beer = $this->Traer($id);
    $envases = $PackagingDAO->SelectAll();
    if (isset($beer)) {
      require 'Views/agregarCerveza.php';
    } else {
      #TODO Cerveza no encontrada
    }
  }
} ?>
