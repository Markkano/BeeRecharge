<?php namespace Controller;

use Model\Send as Send;
use DAOS\SendDAO as SendDAO;
use Model\TimeRange as TimeRange;
use DAOS\TimeRangeDAO as TimeRangeDAO;
use DAOS\StateDAO as StateDAO;

class SendController {

  private $timeRangeDAO;
  private $orderDAO;
  private $sendDAO;

  public function __construct() {
    $this->timeRangeDAO = TimeRangeDAO::getInstance();
    $this->stateDAO = StateDAO::getInstance();
    $this->sendDAO = SendDAO::getInstance();
  }

  public function Index() {
    if (isset($_SESSION['order'])) {
      $order = $_SESSION['order'];
      $client = $order->getClient();
      $time_range_list = $this->timeRangeDAO->SelectAll();
      require_once 'Views/SelectSend.php';
    } else {
      header('location: /'.BASE_URL.'Lobby');
    }
  }

  private function InsertSend($send) {
    return $this->sendDAO->Insert($send);
  }

  public function SubmitSend($select, $address, $id_time_range) {
    if (isset($_SESSION['order'])) {
      $order = $_SESSION['order'];
      $state = $this->stateDAO->SelectById(1);
      $timeRange = $this->timeRangeDAO->SelectById($id_time_range);
      $address = (strcmp($select, '0') == 0) ? $order->getClient()->getAddress() : $address;
      $send = new Send($address, $state, $timeRange);
      $send = $this->InsertSend($send);
      $order->setSend($send);
      $_SESSION['order'] = $order;
      header('location: /'.BASE_URL.'Order/ConfirmOrder');
    } else {
      header('location: /'.BASE_URL.'Lobby');
    }
  }
} ?>
