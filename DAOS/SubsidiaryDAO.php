<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\Subsidiary as Subsidiary;

class SubsidiaryDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Subsidiarys';

  public function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (address, phone, lat, lon) values (?,?,?,?)");
    $stmt->execute(array(
      $object->getAddress(),
      $object->getPhone(),
      $object->getLat(),
      $object->getLon()
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
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_subsidiary = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function DeleteById($id) {
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_subsidiary = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_subsidiary = ? LIMIT 1");
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
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
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
    $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET address = ?, phone = ?, lat = ?, lon = ? WHERE id_subsidiary = ?");
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
