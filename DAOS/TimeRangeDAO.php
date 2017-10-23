<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\TimeRange as TimeRange;
class TimeRangeDAO extends SingletonDAO implements IDAO {

  private $pdo;

  public function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO TimeRanges (from_time, to_time) values (?,?)");
    $stmt->execute(array(
      $object->getFrom(),
      $object->getTo()
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
    $stmt = $this->pdo->Prepare("DELETE FROM TimeRanges WHERE id_time_range = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function DeleteById($id) {
    $stmt = $this->pdo->Prepare("DELETE FROM TimeRanges WHERE id_time_range = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM TimeRanges where id_time_range = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $timeRange = new TimeRange(
          $result['from_time'],
          $result['to_time']
        );
        $timeRange->setId($result['id_time_range']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $timeRange;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectAll() {
    $list = array();
    $stmt = $this->pdo->Prepare("SELECT * FROM TimeRanges");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $timeRange = new TimeRange(
          $result['from_time'],
          $result['to_time']
        );
        $timeRange->setId($result['id_time_range']);
        array_push($list, $timeRange);
      }
    }
    if($stmt->errorCode() == 0) {
      return $list;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function Update($object) {
    $stmt = $this->pdo->Prepare("UPDATE TimeRanges SET from_time = ?, to_time = ? WHERE id_time_range = ?");
    $stmt->execute(array(
      $object->getFrom(),
      $object->getTo(),
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
