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
    $object->setId($pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Packagings WHERE id_packaging = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function DeleteById($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Packagings WHERE id_packaging = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Packagings where id_packaging = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $packaging = new Packaging(
          $result['description'],
          $result['capacity'],
          $result['factor']
        );
        $packaging->setId($result['id_packaging']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $packaging;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
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
    if($stmt->errorCode() == 0) {
      return $envases;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Packagings SET description = ?, capacity = ?, factor = ? WHERE id_packaging = ?");
    $stmt->execute(array(
      $object->getDescription(),
      $object->getCapacity(),
      $object->getFactor(),
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
