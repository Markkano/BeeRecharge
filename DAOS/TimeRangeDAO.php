<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\TimeRange as TimeRange;

class TimeRangeDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'TimeRanges';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (from_time, to_time) values (?,?)");
      $stmt->execute(array(
        $object->getFrom(),
        $object->getTo()
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
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_time_range = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function DeleteById($id) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_time_range = ?");
      return ($stmt->execute(array($id)));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_time_range = ? LIMIT 1");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $timeRange = new TimeRange(
            $result['from_time'],
            $result['to_time']
          );
          $timeRange->setId($result['id_time_range']);
          return $timeRange;
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
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $timeRange = new TimeRange(
            $result['from_time'],
            $result['to_time']
          );
          $timeRange->setId($result['id_time_range']);
          array_push($list, $timeRange);
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
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET from_time = ?, to_time = ? WHERE id_time_range = ?");
      $stmt->execute(array(
        $object->getFrom(),
        $object->getTo(),
        $object->getId()
      ));
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
