<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Account as Account;
class AccountDAO extends SingletonDAO /*implements IDAO*/ {

  private $pdo;
  protected $table = 'Accounts';

  public function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (username, email, password, image) values (?,?,?,?)");
    $stmt->execute(array(
      $object->getUsername(),
      $object->getEmail(),
      $object->getPassword(),
      $object->getImage()
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
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_account = ?");
    $stmt->execute(array($object->getId()));
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_account = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $account = new Account(
          $result['username'],
          $result['email'],
          $result['password'],
          $result['image']
        );
        $account->setId($result['id_account']);
      }
    }
    if($stmt->errorCode() == 0) {
      if (isset($account)) {
        return $account;
      } else {
        return null;
      }
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectByUsername($username) {
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE username = ? LIMIT 1");
    if ($stmt->execute(array($username))) {
      if ($result = $stmt->fetch()) {
        $account = new Account(
          $result['username'],
          $result['email'],
          $result['password'],
          $result['image']
        );
        $account->setId($result['id_account']);
      }
    }
    if($stmt->errorCode() == 0) {
      if (isset($account)) {
        return $account;
      } else {
        return null;
      }
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectAll() {
    $list = array();
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $account = new Account(
          $result['username'],
          $result['email'],
          $result['password'],
          $result['image']
        );
        $account->setId($result['id_account']);
        array_push($list, $account);
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
    $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET name = ?, description = ?, price = ?, graduation = ?, ibu = ?, srm = ?, image = ? WHERE id_account = ?");
    $stmt->execute(array(
      $object->getName(),
      $object->getDescription(),
      $object->getPrice(),
      $object->getGraduation(),
      $object->getIbu(),
      $object->getSrm(),
      $object->getImage(),
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
