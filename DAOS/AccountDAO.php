<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\Account as Account;

class AccountDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Accounts';

  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (username, email, password, image) values (?,?,?,?)");
      $stmt->execute(array(
        $object->getUsername(),
        $object->getEmail(),
        $object->getPassword(),
        $object->getImage()
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
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_account = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
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
          return $account;
        }
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByUsername($username) {
    try {
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
          return $account;
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
          $account = new Account(
            $result['username'],
            $result['email'],
            $result['password'],
            $result['image']
          );
          $account->setId($result['id_account']);
          array_push($list, $account);
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
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET username = ?, email = ?, password = ?, image = ? WHERE id_account = ?");
      $stmt->execute(array(
        $object->getUsername(),
        $object->getEmail(),
        $object->getPassword(),
        $object->getImage(),
        $object->getId()
      ));
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
