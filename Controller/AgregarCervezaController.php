<?php namespace Controller;
use DAOS\BeerDAO as BeerDAO;
use DAOS\PackagingDAO as PackagingDAO;

class AgregarCervezaController {

  private $beerDAO;
  private $packagingDAO;

  public function __construct() {
    $this->beerDAO = BeerDAO::getInstance();
    $this->packagingDAO = PackagingDAO::getInstance();
  }

  public function Traer($id) {
    $beer = $this->beerDAO->SelectByID($id);
    return $beer;
  }

  public function Mostrar($id) {
    $beer = $this->Traer($id);
    $envases = $this->packagingDAO->SelectAll();
    if (isset($beer)) {
      require_once 'Views/agregarCerveza.php';
    } else {
      #TODO Cerveza no encontrada
    }
  }
} ?>
