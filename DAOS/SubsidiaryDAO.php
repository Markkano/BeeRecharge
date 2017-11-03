<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\Subsidiary as Subsidiary;

class SubsidiaryDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Subsidiarys';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (address, phone, lat, lon) values (?,?,?,?)");
      $stmt->execute(array(
        $object->getAddress(),
        $object->getPhone(),
        $object->getLat(),
        $object->getLon()
      ));
      $object->setId($this->pdo->LastInsertId());
      return $object;
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_subsidiary = ?");
      $stmt->execute(array($object->getId()));
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function DeleteById($id) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_subsidiary = ?");
      $stmt->execute(array($id));
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectByID($id) {
    try {
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
          return $subsidiary;
        }
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectAll() {
    try {
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
        return $lista;
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET address = ?, phone = ?, lat = ?, lon = ? WHERE id_subsidiary = ?");
      $stmt->execute(array(
        $object->getAddress(),
        $object->getPhone(),
        $object->getLat(),
        $object->getLon(),
        $object->getId()
      ));
    } catch (\PDOException $e) {
      throw $e;
    }
  }
} ?>
