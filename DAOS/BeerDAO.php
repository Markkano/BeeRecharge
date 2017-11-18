<?php namespace DAOS;

use DAOS\Connection as Connection;
use Model\Beer as Beer;
use Model\Packaging as Packaging;
use DAOS\PackagingDAO as PackagingDAO;

class BeerDAO extends SingletonDAO implements IDAO {

  private $pdo;
  protected $table = 'Beers';
  private $packagingDAO;
  protected function __construct() {
    $this->pdo = Connection::getInstance();
    $this->packagingDAO = PackagingDAO::getInstance();
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
      foreach ($object->getPackagings() as $key) {
        $stmt = $this->pdo->Prepare("INSERT INTO Packagings_Beer (id_beer, id_packaging) VALUES (?,?)");
        $stmt->execute(array(
          $object->getId(),
          $key->getId()
        ));
      }
      return $object;
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function Delete($object) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_beer = ?");
      return ($stmt->execute(array($object->getId())));
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  public function DeleteById($id) {
    try {
      $stmt = $this->pdo->Prepare("DELETE FROM ".$this->table." WHERE id_beer = ?");
      $stmt->execute(array($id));
      return ($stmt->execute(array($id)));
    } catch (\PDOException $e) {
      $this->pdo->getException($e);
    }
  }

  private function getPackagings($id_beer) {
    try {
      $packagings = array();
      $stmt = $this->pdo->Prepare("SELECT * FROM Packagings_Beer WHERE id_beer = ?");
      if ($stmt->execute(array($id_beer))) {
        while ($result = $stmt->fetch()) {
          $pack = $this->packagingDAO->SelectByID($result['id_packaging']);
          if ($pack != null) {
            array_push($packagings, $pack);
          }
        }
      }
      return $packagings;
    } catch (\PDOException $e) {
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
          $packagings = $this->getPackagings($result['id_beer']);
          $beer->setPackagings($packagings);
          return $beer;
        }
      }
    } catch (\PDOException $e) {
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
          $packagings = $this->getPackagings($result['id_beer']);
          $beer->setPackagings($packagings);
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
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET name = ?, description = ?, price = ?, graduation = ?, ibu = ?, srm = ? WHERE id_beer = ?");
      $stmt->execute(array(
        $object->getName(),
        $object->getDescription(),
        $object->getPrice(),
        $object->getGraduation(),
        $object->getIbu(),
        $object->getSrm(),
        $object->getId()
      ));
      $stmt = $this->pdo->Prepare("DELETE FROM Packagings_Beer WHERE id_beer = ?");
      $stmt->execute(array($object->getId()));
      foreach ($object->getPackagings() as $key) {
        $stmt = $this->pdo->Prepare("INSERT INTO Packagings_Beer (id_beer, id_packaging) VALUES (?,?)");
        $stmt->execute(array(
          $object->getId(),
          $key->getId()
        ));
      }
      return $object;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }

  public function UpdateImage($beer) {
    try {
      $stmt = $this->pdo->Prepare("UPDATE ".$this->table." SET image = ? WHERE id_beer = ?");
      $stmt->execute(array(
        $beer->getImage(),
        $beer->getId()
      ));
      return $beer;
    } catch (\PDOException $e) {
      //throw $e;
      $this->pdo->getException($e);
    }
  }
} ?>
