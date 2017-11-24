<?php namespace Controller;

use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Order as Order;

class ElegirSucursalController {

  private $subsidiaryDAO;

  public function __construct() {
    $this->subsidiaryDAO = SubsidiaryDAO::getInstance();
  }

  public function Index($id_subsidiary) {
    try {
      $subsidiary = $this->subsidiaryDAO->SelectByID($id_subsidiary);
      if (isset($_SESSION['order'])) {
        $order = $_SESSION['order'];
      } else {
        $order = new Order(null, null, $_SESSION['client'], null);
      }
      $order->setSubsidiary($subsidiary);
      $_SESSION['order'] = $order;
      header('location: /'.BASE_URL.'Lobby/SubmitOrder');
    } catch (Exception $e) {
      echo "Error! ".$e->getMessage();
    }
  }
} ?>
