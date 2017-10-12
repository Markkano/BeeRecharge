<?php namespace DAOS;
use DAOS\Connection as Connection;
use DAOS\BeerDAO as BeerDAO;
use DAOS\PackagingDAO as PackagingDAO;
use Model\OrderLine as OrderLine;
#use Model\Beer as Beer;
#use Model\Packaging as Packaging;
#use Model\Order as Order;
class OrderLineDAO extends SingletonDAO implements IDAO {

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO OrderLines (amount, price, id_beer, id_packaging, id_order) values (?,?,?,?,?)");
    $stmt->execute(array(
      $object->getAmount(),
      $object->getPrice(),
      $object->getBeer()->getId(),
      $object->getPackaging()->getId(),
      $object->getOrder()->getId()
    ));
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM OrderLines WHERE id_order_line = ?");
    $stmt->execute(array($object->getId()));
  }

  public function SelectByID($id) {


    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM OrderLines where id_order_line = ?");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $beer = $BeerDAO->SelectByID($result['id_beer']);
        $packaging = $PackagingDAO->SelectByID($result['id_packaging']);
        $order = $OrderDAO->SelectByID($result['order_number']);
        $orderLine = new OrderLine(
          $result['amount'],
          $result['price'],
          $beer,
          $packaging,
          $order
        );
        $orderLine->setId($result['id_order_line']);
        return $orderLine;
      }
    }
  }

  public function SelectAll() {
    $BeerDAO = new BeerDAO();
    $PackagingDAO = new PackagingDAO();
    $OrderDAO = new OrderDAO();

    $lines = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM OrderLines");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $beer = $BeerDAO->SelectByID($result['id_beer']);
        $packaging = $PackagingDAO->SelectByID($result['id_packaging']);
        $order = $OrderDAO->SelectByID($result['order_number']);
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
    return $lines;
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE OrderLines SET (amount = ?, price = ?, id_beer = ?, id_packaging = ?, id_order = ?) WHERE id_order_line = ?");
    $stmt->execute(array(
      $object->getAmount(),
      $object->getPrice(),
      $object->getBeer()->getId(),
      $object->getPackaging()->getId(),
      $object->getOrder()->getId(),
      $object->getId()
    ));
  }
} ?>
