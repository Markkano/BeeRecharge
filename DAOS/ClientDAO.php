<?php namespace DAOS;

use DAOS\Connection as Connection;
use DAOS\AccountDAO as AccountDAO;
use Model\Client as Client;

class ClientDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Clients';
  private $AccountDAO;

  protected function __construct() {
    $this->pdo = Connection::getInstance();
    $this->AccountDAO = AccountDAO::getInstance();
  }

  public function Insert($object) {
    try {
      $this->AccountDAO->Insert($object->getAccount());
      $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (name, surname, dni, address, phone, id_account) values (?,?,?,?,?,?)");
      $stmt->execute(array(
        $object->getName(),
        $object->getSurname(),
        $object->getDni(),
        $object->getAddress(),
        $object->getPhone(),
        $this->pdo->LastInsertId()
      ));
      $object->setId($this->pdo->LastInsertId());
      return $object;
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_client = ?");
      $stmt->execute(array($object->getId()));
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectByID($id) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE id_client = ?  LIMIT 1");
      if ($stmt->execute(array($id))) {
        if ($result = $stmt->fetch()) {
          $account = $this->AccountDAO->SelectByID($result['id_account']);
          $client = new Client(
            $result['name'],
            $result['surname'],
            $result['dni'],
            $result['address'],
            $result['phone'],
            $account
          );
          $client->setId($result['id_client']);
          return $client;
        }
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectByDNI($dni_client) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE dni = ?  LIMIT 1");
      if ($stmt->execute(array($dni_client))) {
        if ($result = $stmt->fetch()) {
          $account = $this->AccountDAO->SelectByID($result['id_account']);
          $client = new Client(
            $result['name'],
            $result['surname'],
            $result['dni'],
            $result['address'],
            $result['phone'],
            $account
          );
          $client->setId($result['id_client']);
          return $client;
        }
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectByAccount($object) {
    try {
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." WHERE id_account = ?  LIMIT 1");
      if ($stmt->execute(array($object->getId()))) {
        if ($result = $stmt->fetch()) {
          $account = $this->AccountDAO->SelectByID($result['id_account']);
          $client = new Client(
            $result['name'],
            $result['surname'],
            $result['dni'],
            $result['address'],
            $result['phone'],
            $account
          );
          $client->setId($result['id_client']);
          return $client;
        }
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function SelectAll() {
    try {
      $list = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
      if ($stmt->execute()) {
        while ($result = $stmt->fetch()) {
          $account = $this->AccountDAO->SelectByID($result['id_account']);
          $client = new Client(
            $result['name'],
            $result['surname'],
            $result['dni'],
            $result['address'],
            $result['phone'],
            $account
          );
          $client->setId($result['id_client']);
          array_push($list, $client);
        }
        return $list;
      }
    } catch (\PDOException $e) {
      throw $e;
    }
  }

  public function Update($object) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET name = ?, surname = ?, dni = ?, address = ?, phone = ?, id_account = ? WHERE id_client = ?");
      $stmt->execute(array(
        $object->getName(),
        $object->getSurname(),
        $object->getDni(),
        $object->getAddress(),
        $object->getPhone(),
        $object->getAccount()->getId(),
        $object->getId()
      ));
    } catch (\PDOException $e) {
      throw $e;
    }
  }
} ?>
