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
  }

  public function Index() {
    require_once 'Views/SubmitOrder.php';
  }

  public function NewOrder($select) {
    if (isset($_SESSION['order'])) {
      $order = $_SESSION['order'];
      if (strcmp($select, '2') == 0) {
        header('location: /'.BASE_URL.'Send');
      } else {
        $this->ConfirmOrder();
      }
    } else {
      header('location: /'.BASE_URL.'Lobby');
    }
  }

  public function ConfirmOrder() {
    if (isset($_SESSION['order'])) {
      $order = $_SESSION['order'];
      try {
        $state = $this->stateDAO->SelectById(1);
        $order->setState($state);
        $order = $this->orderDAO->Insert($order);
        $this->DeleteOrder();
      } catch (\Exception $e) {
      }
    }
    header('location: /'.BASE_URL.'Lobby');
  }

  public function DeleteOrder() {
    unset($_SESSION['order']);
    header('location: /'.BASE_URL.'Lobby');
  }
} ?>
