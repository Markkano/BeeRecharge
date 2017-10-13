<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Role as Role;
class RoleDAO extends SingletonDAO implements IDAO {

  public function __construct() {}

  public function Insert($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("INSERT INTO Roles (name, description, price, graduation, ibu, srm, image) values (?,?,?,?,?,?,?)");
    $stmt->execute(array(
      $object->getName(),
      $object->getDescription(),
      $object->getPrice(),
      $object->getGraduation(),
      $object->getIbu(),
      $object->getSrm(),
      $object->getImage()
    ));
  }

  public function Delete($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("DELETE FROM Roles WHERE id_beer = ?");
    $stmt->execute(array($object->getId()));
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Roles where id_beer = ?");
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
        return $beer;
      }
    }
  }

  public function SelectAll() {
    $cervezas = array();
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Roles");
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
    return $cervezas;
  }

  public function Update($object) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("UPDATE Roles SET (name = ?, description = ?, price = ?, graduation = ?, ibu = ?, srm = ?, image = ?) WHERE id_beer = ?");
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
  }
} ?>
