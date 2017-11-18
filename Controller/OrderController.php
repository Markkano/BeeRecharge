<?php namespace Controller;

use DAOS\StateDAO as StateDAO;
use DAOS\OrderDAO as OrderDAO;
use Model\Order as Order;

class OrderController {

  private $orderDAO;
  private $stateDAO;

  public function __construct() {
    $this->orderDAO = OrderDAO::getInstance();
    $this->stateDAO = StateDAO::getInstance();
    require_once 'Views/Order.php';
  }

  public function Index() {

  }

  public function NewOrder() {
    if (isset($_SESSION['order'])) {
      $order = $_SESSION['order'];
      try {
        $state = $this->stateDAO->SelectById(1);
        $order->setState($state);
        $order = $this->orderDAO->Insert($order);
        $this->DeleteOrder();
        if (!isset($order)) {
          throw new \Exception("Ocurrio un problema al insertar la orden", 1);
        }
      } catch (\Exception $e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
      }
    } else {
      header('location: /'.BASE_URL.'Lobby');
    }
  }

  public function DeleteOrder() {
    unset($_SESSION['order']);
    header('location: /'.BASE_URL.'Lobby');
  }
} ?>
