<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Packaging as Packaging;
class PackagingDAO extends SingletonDAO implements IDAO {

  public function __construct() {}

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Packagings (description, capacity, factor) values (?,?,?)");
    $stmt->execute(array(
      $object->getDescription(),
      $object->getCapacity(),
      $object->getFactor(),
    ));
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Packagings WHERE id_packaging = ?");
    $stmt->execute(array($object->getId()));
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Packagings where id_packaging = ?");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $packaging = new Packaging(
          $result['description'],
          $result['capacity'],
          $result['factor']
        );
        $packaging->setId($result['id_packaging']);
        return $packaging;
      }
    }
  }

  public function SelectAll() {
    $envases = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Packagings");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $packaging = new Packaging(
          $result['description'],
          $result['capacity'],
          $result['factor']
        );
        $packaging->setId($result['id_packaging']);
        array_push($envases, $packaging);
      }
    }
    return $envases;
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Packagings SET (description = ?, capacity = ?, factor = ?) WHERE id_packaging = ?");
    $stmt->execute(array(
      $object->getDescription(),
      $object->getCapacity(),
      $object->getFactor(),
      $object->getId()
    ));
  }
} ?>
