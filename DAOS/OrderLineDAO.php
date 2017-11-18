<?php namespace DAOS;
use DAOS\Connection as Connection;
use DAOS\BeerDAO as BeerDAO;
use DAOS\PackagingDAO as PackagingDAO;
use Model\OrderLine as OrderLine;

class OrderLineDAO extends SingletonDAO /*implements IDAO */{

  private $pdo;
  protected $table = 'OrderLines';
  private $beerDAO;
  private $PackagingDAO;

  protected function __construct() {
    $this->pdo = Connection::getInstance();
    $this->beerDAO = BeerDAO::getInstance();
    $this->PackagingDAO = PackagingDAO::getInstance();
  }

  public function Insert($object, $order_number) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (amount, price, id_beer, id_packaging, order_number) values (?,?,?,?,?)");
      $stmt->execute(array(
        $object->getAmount(),
        $object->getPrice(),
        $object->getBeer()->getId(),
        $object->getPackaging()->getId(),
        $order_number
      ));
      $object->setId($this->pdo->LastInsertId());
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_order_line = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_order_line = ? LIMIT 1");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $beer = $this->beerDAO->SelectByID($result['id_beer']);
          $packaging = $this->PackagingDAO->SelectByID($result['id_packaging']);
          $orderLine = new OrderLine(
            $result['amount'],
            $result['price'],
            $beer,
            $packaging
          );
          $orderLine->setId($result['id_order_line']);
          return $orderLine;
        }
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAll() {
    try {
      $lines = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $beer = $this->beerDAO->SelectByID($result['id_beer']);
          $packaging = $this->PackagingDAO->SelectByID($result['id_packaging']);
          $orderLine = new OrderLine(
            $result['amount'],
            $result['price'],
            $beer,
            $packaging
          );
          $orderLine->setId($result['id_order_line']);
          array_push($lines, $orderLine);
        }
        return $lines;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAllFromOrderNumber($order_number) {
    try {
      $lines = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE order_number = ? ");
      if ($stmt->execute(array($order_number))) {
        while ($result = $stmt->fetch()) {
          $beer = $this->beerDAO->SelectByID($result['id_beer']);
          $packaging = $this->PackagingDAO->SelectByID($result['id_packaging']);
          $orderLine = new OrderLine(
            $result['amount'],
            $result['price'],
            $beer,
            $packaging
          );
          $orderLine->setId($result['id_order_line']);
          array_push($lines, $orderLine);
        }
        return $lines;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET amount = ?, price = ?, id_beer = ?, id_packaging = ?, id_order = ? WHERE id_order_line = ?");
      $stmt->execute(array(
        $object->getAmount(),
        $object->getPrice(),
        $object->getBeer()->getId(),
        $object->getPackaging()->getId(),
        $object->getOrder()->getId(),
        $object->getId()
      ));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
