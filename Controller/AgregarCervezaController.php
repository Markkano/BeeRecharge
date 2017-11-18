<?php namespace Controller;

use Model\Beer as Beer;
use DAOS\BeerDAO as BeerDAO;
use Model\Packaging as Packaging;
use DAOS\PackagingDAO as PackagingDAO;
use Model\Order as Order;

class AgregarCervezaController {

  private $beerDAO;
  private $packagingDAO;

  public function __construct() {
    $this->beerDAO = BeerDAO::getInstance();
    $this->packagingDAO = PackagingDAO::getInstance();
  }

  public function NewBeer($id_beer, $id_packaging, $cant) {
    try {
      $beer = $this->beerDAO->SelectByID($id_beer);
      $packaging = $this->packagingDAO->SelectByID($id_packaging);
      if (isset($_SESSION['order'])) {
        $order = $_SESSION['order'];
      } else {
        $order = new Order(null, null, $_SESSION['client'], null);
      }
      $order->NewOrderLine($beer, $packaging, $cant);
      $_SESSION['order'] = $order;
      header('location: /'.BASE_URL.'Lobby');
    } catch (Exception $e) {
      echo "Error! ".$e->getMessage();
    }
  }
} ?>
