<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Beer as Beer;
class BeerDAO extends SingletonDAO implements IDAO {

  public function __construct() {}

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Beers (name, description, price, graduation, ibu, srm, image) values (?,?,?,?,?,?,?)");
    $stmt->execute(array(
      $object->getName(),
      $object->getDescription(),
      $object->getPrice(),
      $object->getGraduation(),
      $object->getIbu(),
      $object->getSrm(),
      $object->getImage()
    ));
    $object->setId($pdo->LastInsertId());
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Beers WHERE id_beer = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function DeleteById($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Beers WHERE id_beer = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Beers where id_beer = ? LIMIT 1");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $beer = new Beer(
          $result['name'],
          $result['description'],
          $result['price'],
          $result['ibu'],
          $result['srm'],
          $result['graduation'],
          $result['image']
        );
        $beer->setId($result['id_beer']);
      }
    }
    if($stmt->errorCode() == 0) {
      return $beer;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectAll() {
    $cervezas = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Beers");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $beer = new Beer(
          $result['name'],
          $result['description'],
          $result['price'],
          $result['ibu'],
          $result['srm'],
          $result['graduation'],
          $result['image']
        );
        $beer->setId($result['id_beer']);
        array_push($cervezas, $beer);
      }
    }
    if($stmt->errorCode() == 0) {
      return $cervezas;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Beers SET name = ?, description = ?, price = ?, graduation = ?, ibu = ?, srm = ?, image = ? WHERE id_beer = ?");
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
