<?php namespace Controller;

use Model\Order as Order;
use DAOS\BeerDAO as BeerDAO;
use DAOS\PackagingDAO as PackagingDAO;
use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use DAOS\TimeRangeDAO as TimeRangeDAO;
use DAOS\ClientDAO as ClientDAO;

class LobbyController {

  private $beerDAO;
  private $packagingDAO;
  private $subsidiaryDAO;
  private $timeRangeDAO;
  private $clientDAO;

  public function __construct() {
    $this->beerDAO = BeerDAO::getInstance();
    $this->packagingDAO = PackagingDAO::getInstance();
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
    $this->timeRangeDAO = TimeRangeDAO::getInstance();
    $this->clientDAO = ClientDAO::getInstance();
    if (!isset($_SESSION['account'])) {
      header('location: /'.BASE_URL);
    }
    if (!isset($_SESSION['order'])) {
      $client = $this->clientDAO->SelectByAccount($_SESSION['account']);
      $_SESSION['order'] = new Order(null, null, $client, null);
    }
    require_once 'Views/Lobby.php';
  }

  public function Index() {
    $cervezas = $this->beerDAO->SelectAll();
    require_once 'Views/ListaCervezas.php';
  }

  public function AgregarCerveza($id_beer) {
    try {
      $beer = $this->beerDAO->SelectByID($id_beer);
      if (isset($beer)) {
        require_once 'Views/AgregarCerveza.php';
      } else {
      }
    } catch (\Exception $e) {
    }
  }

  public function ElegirSucursal() {
    $subsidiarys = $this->subsidiaryDAO->SelectAll();
    require_once 'Views/ElegirSucursal.php';
  }

  public function SubmitOrder() {
    if (isset($_SESSION['order'])) {
      $order = $_SESSION['order'];
      $subsidiary = $order->getSubsidiary();
      require_once 'Views/SubmitOrder.php';
    } else {
      header('location: /'.BASE_URL.'Lobby');
    }
  }
} ?>
