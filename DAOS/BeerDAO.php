<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\Beer as Beer;

class BeerDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Beers';
  protected function __construct() {
    $this->pdo = Connection::getInstance();
  }

  public function Insert($object) {
    try {
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
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_beer = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function DeleteById($id) {
    try {
      $stmt->execute(array($id));
      return ($stmt->execute(array($id)));
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectByID($id) {
    try {
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
          return $beer;
        }
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function SelectAll() {
    try {
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
        return $cervezas;
      }
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function Update($object) {
    try {
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
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
