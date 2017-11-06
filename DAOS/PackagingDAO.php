<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Packaging as Packaging;
class PackagingDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Packagings';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (description, capacity, factor) values (?,?,?)");
      $stmt->execute(array(
        $object->getDescription(),
        $object->getCapacity(),
        $object->getFactor(),
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
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_packaging = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function DeleteById($id) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_packaging = ?");
      return ($stmt->execute(array($id)));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
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
        return $packaging;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAll() {
    try {
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
        return $envases;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET description = ?, capacity = ?, factor = ? WHERE id_packaging = ?");
      $stmt->execute(array(
        $object->getDescription(),
        $object->getCapacity(),
        $object->getFactor(),
        $object->getId()
      ));
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
