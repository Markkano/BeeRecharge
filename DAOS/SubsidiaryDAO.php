<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\Subsidiary as Subsidiary;

class SubsidiaryDAO extends SingletonDAO implements IDAO {

  public function __construct() {}

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Subsidiarys (address, phone, lat, lon) values (?,?,?,?)");
    $stmt->execute(array(
      $object->getAddress(),
      $object->getPhone(),
      $object->getLat(),
      $object->getLon()
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
    $stmt = $pdo->Prepare("DELETE FROM Subsidiarys WHERE id_subsidiary = ?");
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
    $stmt = $pdo->Prepare("DELETE FROM Subsidiarys WHERE id_subsidiary = ?");
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
    $stmt = $pdo->Prepare("SELECT * FROM Subsidiarys where id_subsidiary = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $subsidiary = new Subsidiary(
          $result['address'],
          $result['phone'],
          $result['lat'],
          $result['lon']
        );
        $subsidiary->setId($result['id_subsidiary']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $subsidiary;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectAll() {
    $lista = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Subsidiarys");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $subsidiary = new Subsidiary(
          $result['address'],
          $result['phone'],
          $result['lat'],
          $result['lon']
        );
        $subsidiary->setId($result['id_subsidiary']);
        array_push($lista, $subsidiary);
      }
    }
    if($stmt->errorCode() == 0) {
      return $lista;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Subsidiarys SET address = ?, phone = ?, lat = ?, lon = ? WHERE id_subsidiary = ?");
    $stmt->execute(array(
      $object->getAddress(),
      $object->getPhone(),
      $object->getLat(),
      $object->getLon(),
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
