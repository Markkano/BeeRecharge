<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Client as Client;
class ClientDAO extends SingletonDAO implements IDAO {

  private $AccountDAO;

  public function __construct() {
    $this->$AccountDAO = new AccountDAO();
  }

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Clients (name, surname, dni, address, phone, id_account) values (?,?,?,?,?,?)");
    $stmt->execute(array(
      $object->getName(),
      $object->getSurname(),
      $object->getDni(),
      $object->getAddress(),
      $object->getPhone(),
      $object->getAccount()->getId()
    ));
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Clients WHERE id_client = ?");
    $stmt->execute(array($object->getId()));
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Clients where id_client = ?");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $account = $this->$AccountDAO->SelectByID($result['id_account']);
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
  }

  public function SelectAll() {
    $list = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Clients");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $account = $this->$AccountDAO->SelectByID($result['id_account']);
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
    }
    return $list;
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Clients SET (name = ?, surname = ?, dni = ?, address = ?, phone = ?, id_account = ?) WHERE id_client = ?");
    $stmt->execute(array(
      $object->getName(),
      $object->getSurname(),
      $object->getDni(),
      $object->getAddress(),
      $object->getPhone(),
      $object->getAccount()->getId(),
      $object->getId()
    ));
  }
} ?>
