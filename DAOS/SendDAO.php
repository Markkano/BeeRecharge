<?php namespace DAOS;

use DAOS\Connection as Connection;
use DAOS\TimeRangeDAO as TimeRangeDAO;
use DAOS\StateDAO as StateDAO;
use Model\Send as Send;

class SendDAO extends SingletonDAO implements IDAO {

  private $pdo;
  private $stateDAO;
  private $timeRangeDAO;
  protected $table = 'Sends';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
    $this->stateDAO = StateDAO::getInstance();
    $this->timeRangeDAO = TimeRangeDAO::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (address, id_state, id_time_range) values (?,?,?)");
      $stmt->execute(array(
        $object->getAddress(),
        $object->getState()->getId(),
        $object->getTimeRange()->getId()
      ));
      $object->setId($this->pdo->LastInsertId());
      return $object;
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function Delete($object) {
    try {
      return ($this->DeleteById(array($object->getId())));
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function DeleteById($id_send) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_send = ?");
      return ($stmt->execute(array($id_send)));
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_send = ? LIMIT 1");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $time_range = $this->timeRangeDAO->SelectByID($result['id_time_range']);
          $send = new Send(
            $result['address'],
            $state,
            $time_range
          );
          $send->setId($result['id_send']);
          return $send;
        }
      }
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function SelectAll() {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." ORDER BY id_send ASC");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $state = $this->stateDAO->SelectByID($result['id_state']);
          $time_range = $this->timeRangeDAO->SelectByID($result['id_time_range']);
          $send = new Send(
            $result['address'],
            $state,
            $time_range
          );
          $send->setId($result['id_send']);
          array_push($list, $send);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET state = ?, id_state = ?, id_time_range = ? WHERE id_send = ?");
      $stmt->execute(array(
        $object->getAddress(),
        $object->getState()->getId(),
        $object->getTimeRange()->getId(),
        $object->getId()
      ));
      return $object;
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }
} ?>
