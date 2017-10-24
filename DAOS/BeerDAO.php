<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Beer as Beer;
class BeerDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Beers';
  public function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    $stmt = $this->pdo->Prepare("INSERT INTO ".$this->table." (name, description, price, graduation, ibu, srm, image) values (?,?,?,?,?,?,?)");
    $stmt->execute(array(
      $object->getName(),
      $object->getDescription(),
      $object->getPrice(),
      $object->getGraduation(),
      $object->getIbu(),
      $object->getSrm(),
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
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_beer = ?");
    $stmt->execute(array($object->getId()));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function DeleteById($id) {
    $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_beer = ?");
    $stmt->execute(array($id));
    if($stmt->errorCode() == 0) {
      return null;
    } else {
      $errors = $stmt->errorInfo();
      return $errors[2];
    }
  }

  public function SelectByID($id) {
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table." where id_beer = ? LIMIT 1");
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
    $stmt = $this->pdo->Prepare("SELECT * FROM ".$this->table."");
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
    $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET name = ?, description = ?, price = ?, graduation = ?, ibu = ?, srm = ?, image = ? WHERE id_beer = ?");
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
