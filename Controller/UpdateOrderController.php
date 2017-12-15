<?php namespace Controller;

use DAOS\OrderDAO as OrderDAO;
use DAOS\StateDAO as StateDAO;

class UpdateOrderController {

  private $orderDAO;

  public function __construct() {
    $this->orderDAO = OrderDAO::getInstance();
    $this->stateDAO = StateDAO::getInstance();
  }

  public function Update($order_number, $id_state) {
    try {
      $order = $this->orderDAO->SelectById($order_number);
      $state = $this->stateDAO->SelectById($id_state);
      $order->setState($state);
      $order = $this->orderDAO->Update($order);
      echo $order->getState()->getId();
    } catch (Exception $e) {
      echo "error";
    }
  }
} ?>
