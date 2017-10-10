<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Beer as Beer;


class BeerDAO extends SingletonDAO implements IDAO {

  public function __construct() {}

  public function Insert($object) {
  }

  public function Delete($object) {
  }

  public function SelectByID($id) {
    $pdo = Connection::getInstance();
    $stmt = $pdo->Prepare("SELECT * FROM Beers where id_beer = ?");
    if ($stmt->execute(array($id))) {
      if ($result = $stmt->fetch()) {
        $beer = new Beer(
          $result['name'],
          $result['description'],
          $result['price'],
          $result['graduation'],
          $result['ibu'],
          $result['srm'],
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
    $stmt = $pdo->Prepare("SELECT * FROM Beers");
    if ($stmt->execute()) {
      while ($result = $stmt->fetch()) {
        $beer = new Beer(
          $result['name'],
          $result['description'],
          $result['price'],
          $result['graduation'],
          $result['ibu'],
          $result['srm']
        );
        $beer->setId($result['id_beer']);
        array_push($cervezas, $beer);
      }
    }
    return $cervezas;
  }

  public function Update($object) {
  }
} ?>
