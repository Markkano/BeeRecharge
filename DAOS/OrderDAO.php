<?php namespace DAOS;
use DAOS\Connection as Connection;
use DAOS\ClientDAO as ClientDAO;
use Model\Order as Order;
class ClientDAO extends SingletonDAO implements IDAO {

  private $ClientDAO;

  public function __construct() {
    $this->$ClientDAO = new ClientDAO();
  }

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Orders (order_number, order_date, state, id_client) values (?,?,?,?)");
    $stmt->execute(array(
      $object->getOrderNumber(),
      $object->getOrderDate(),
      $object->getState(),
      $object->getClient()->getId()
    ));
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Orders WHERE id_order = ?");
    $stmt->execute(array($object->getId()));
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders where id_order = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $order = $this->$ClientDAO->SelectByID($result['id_client']);
        $order = new Order(
          $result['order_number'],
          $result['order_date'],
          $result['state'],
          $client
        );
        $order->setId($result['id_client']);
        return $order;
      }
    }
  }

  public function SelectAll() {
    $list = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $client = $this->$ClientDAO->SelectByID($result['id_client']);
        $order = new Order(
          $result['order_number'],
          $result['order_date'],
          $result['state'],
          $client
        );
        $order->setId($result['id_client']);
        array_push($list, $order);
      }
    }
    return $list;
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Orders SET (order_number = ?, order_date = ?, state = ?, id_client = ?) WHERE id_order = ?");
    $stmt->execute(array(
      $object->getOrderNumber(),
      $object->getOrderDate(),
      $object->getState(),
      $object->getClient()->getId(),
      $object->getId()
    ));
  }
} ?>
