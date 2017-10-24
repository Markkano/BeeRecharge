<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Packaging as Packaging;
class PackagingDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Packagings';

  public function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (description, capacity, factor) values (?,?,?)");
    $stmt->execute(array(
      $object->getDescription(),
      $object->getCapacity(),
      $object->getFactor(),
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
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_packaging = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function DeleteById($id) {
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_packaging = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
        $errors = $stmt->errorInfo();
        return $errors[2];
    }
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_packaging = ? LIMIT 1");
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
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." ORDER BY capacity ASC");
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
    $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET description = ?, capacity = ?, factor = ? WHERE id_packaging = ?");
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
