<?php namespace DAOS;
use Model\Packaging as Packaging;
class PackagingDAO extends SingletonDAO implements IDAO {

  public function __construc() {}

  public function Insert($object) {
  }

  public function Delete($object) {
  }

  public function SelectByID($id) {
  }

  public function SelectAll() {
    $envases = array();
    array_push($envases, new Packaging(
      "Botellon de 2 Litros", 2.0, 0.9
    ));
    array_push($envases, new Packaging(
      "Porrón", 0.473, 1.2
    ));
    array_push($envases, new Packaging(
      "Botella aniversario", 0.75, 1.0
    ));
    return $envases;
  }

  public function Update($object) {
  }
} ?>
