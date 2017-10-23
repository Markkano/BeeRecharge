<?php namespace DAOS;
use DAOS\Connection as Connection;
use DAOS\BeerDAO as BeerDAO;
use DAOS\PackagingDAO as PackagingDAO;
use Model\OrderLine as OrderLine;

class OrderLineDAO extends SingletonDAO implements IDAO {

  private $pdo;
  private $BeerDAO;
  private $PackagingDAO;
  private $OrderDAO;

  public function __construct() {
    $this->pdo = Connection::getInstance();
    $this->BeerDAO = new BeerDAO();
    $this->PackagingDAO = new PackagingDAO();
    $this->OrderDAO = new OrderDAO();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO OrderLines (amount, price, id_beer, id_packaging, id_order) values (?,?,?,?,?)");
    $stmt->execute(array(
      $object->getAmount(),
      $object->getPrice(),
      $object->getBeer()->getId(),
      $object->getPackaging()->getId(),
      $object->getOrder()->getId()
    ));
    $object->setId($this->pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Delete($object) {
    $stmt = $this->pdo->Prepare("DELETE FROM OrderLines WHERE id_order_line = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM OrderLines where id_order_line = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $beer = $this->BeerDAO->SelectByID($result['id_beer']);
        $packaging = $this->PackagingDAO->SelectByID($result['id_packaging']);
        $order = $this->OrderDAO->SelectByID($result['order_number']);
        $orderLine = new OrderLine(
          $result['amount'],
          $result['price'],
          $beer,
          $packaging,
          $order
        );
        $orderLine->setId($result['id_order_line']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $orderLine;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAll() {
    $lines = array();
    $stmt = $this->pdo->Prepare("SELECT * FROM OrderLines");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $beer = $this->BeerDAO->SelectByID($result['id_beer']);
        $packaging = $this->PackagingDAO->SelectByID($result['id_packaging']);
        $order = $this->OrderDAO->SelectByID($result['order_number']);
        $orderLine = new OrderLine(
          $result['amount'],
          $result['price'],
          $beer,
          $packaging,
          $order
        );
        $orderLine->setId($result['id_order_line']);
        array_push($lines, $beer);
      }
    }
    if($stmt->errorCode() == 0) {
      return $lines;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Update($object) {
    $stmt = $this->pdo->Prepare("UPDATE OrderLines SET amount = ?, price = ?, id_beer = ?, id_packaging = ?, id_order = ? WHERE id_order_line = ?");
    $stmt->execute(array(
      $object->getAmount(),
      $object->getPrice(),
      $object->getBeer()->getId(),
      $object->getPackaging()->getId(),
      $object->getOrder()->getId(),
      $object->getId()
    ));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }
} ?>
