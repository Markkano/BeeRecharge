<?php namespace DAOS;
use DAOS\Connection as Connection;
use DAOS\ClientDAO as ClientDAO;
use DAOS\SubsidiaryDAO as SubsidiaryDAO;
use Model\Order as Order;
class ClientDAO extends SingletonDAO implements IDAO {

  private $ClientDAO;
  private $subsidiaryDAO;

  public function __construct() {
    $this->ClientDAO = new ClientDAO();
    $this->subsidiaryDAO = new SubsidiaryDAO();
  }

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Orders (order_date, state, id_client, id_subsidiary) values (?,?,?,?,?)");
    $stmt->execute(array(
      $object->getOrderDate(),
      $object->getState(),
      $object->getClient()->getId(),
      $object->getSubsidiary()->getId()
    ));
    $object->setOrderNumber($pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Orders WHERE order_number = ?");
    $stmt->execute(array($object->getOrderNumber()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders where order_number = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $order = $this->ClientDAO->SelectByID($result['id_client']);
        $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
        $order = new Order(
          $result['order_date'],
          $result['state'],
          $client,
          $subsidiary
        );
        $order->setOrderNumber($result['order_number']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $order;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAll() {
    $list = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $client = $this->ClientDAO->SelectByID($result['id_client']);
        $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
        $order = new Order(
          $result['order_date'],
          $result['state'],
          $client,
          $subsidiary
        );
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  // TODO: Definir parametros
  public function SelectAllFromClient() {
    $list = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders WHERE id_client = ?");
    if ($stmt->execute(array(/***/))) {
      while ($result = $stmt->fetch()) {
        $client = $this->ClientDAO->SelectByID($result['id_client']);
        $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
        $order = new Order(
          $result['order_date'],
          $result['state'],
          $client,
          $subsidiary
        );
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  // TODO: Definir parametros
  public function SelectAllFromSubsidiary() {
    $list = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders WHERE id_subsidiary = ?");
    if ($stmt->execute(array(/***/))) {
      while ($result = $stmt->fetch()) {
        $client = $this->ClientDAO->SelectByID($result['id_client']);
        $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
        $order = new Order(
          $result['order_date'],
          $result['state'],
          $client,
          $subsidiary
        );
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  // TODO: Definir parametros
  public function SelectAllFromDate() {
    $list = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Orders WHERE order_date = ?");
    if ($stmt->execute(array(/***/))) {
      while ($result = $stmt->fetch()) {
        $client = $this->ClientDAO->SelectByID($result['id_client']);
        $subsidiary = $this->subsidiaryDAO->SelectByID($result['id_subsidiary']);
        $order = new Order(
          $result['order_date'],
          $result['state'],
          $client,
          $subsidiary
        );
        $order->setOrderNumber($result['order_number']);
        array_push($list, $order);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Orders SET order_date = ?, state = ?, id_client = ?, id_subsidiary = ? WHERE order_number = ?");
    $stmt->execute(array(
      $object->getOrderDate(),
      $object->getState(),
      $object->getClient()->getId(),
      $object->getSubsidiary()->getId(),
      $object->getOrderNumber()
    ));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }
} ?>
