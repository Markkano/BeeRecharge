<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\State as State;

class StateDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'States';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (state) values (?)");
      $stmt->execute(array(
        $object->getState()
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
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_state = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function DeleteById($id_state) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_state = ?");
      return ($stmt->execute(array($id_state)));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_state = ? LIMIT 1");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $state = new State(
            $result['state']
          );
          $state->setId($result['id_state']);
          return $state;
        }
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAll() {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." ORDER BY id_state ASC");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $state = new State(
            $result['state']
          );
          $state->setId($result['id_state']);
          array_push($list, $state);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET state = ? WHERE id_state = ?");
      $stmt->execute(array(
        $object->getState(),
        $object->getId()
      ));
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
