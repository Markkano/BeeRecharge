<?php namespace DAOS;
use DAOS\Connection as Connection;
use Model\Beer as Beer;

class BeerDAO extends SingletonDAO implements IDAO {

  public function Insert($object) {
  }

  public function Delete($object) {
  }

  public function SelectByID($id) {
    $name = "Amber Lager Premium";
    $description = "Lager es un tipo de cerveza con sabor acentuado que se sirve fría, caracterizada por fermentar en condiciones más lentas empleando levaduras especiales, conocidas como levaduras de fermentación baja, y que en las últimas partes del proceso son almacenadas en bodegas durante un período en condiciones de baja temperatura con el objeto de limpiar las partículas residuales y estabilizar los sabores.";
    $price = 85.3;
    $image = "beer.jpg";
    $ibu = 15;
    $srm = 25;
    $graduation = 12.5;
    return new Beer($name, $description, $price, $image, $ibu, $srm, $graduation);
  }

  public function SelectAll() {
    $cerverzas = array();
    $name = "Amber Lager Premium";
    $description = "";
    $price = 85.5;
    $image = "beer.jpg";
    $ibu = 14;
    $srm = 23;
    $graduation = 12.5;
    $beer = new Beer($name, $description, $price, $image, $ibu, $srm, $graduation);
    $beer->setId(1);
    array_push($cerverzas, $beer);
    $name = "Stout";
    $description = "";
    $price = 98;
    $image = "beer.jpg";
    $ibu = 9;
    $srm = 35;
    $graduation = 9;
    $beer = new Beer($name, $description, $price, $image, $ibu, $srm, $graduation);
    $beer->setId(2);
    array_push($cerverzas, $beer);
    $name = "Pilsner";
    $description = "";
    $price = 60.0;
    $image = "beer.jpg";
    $ibu = 23;
    $srm = 18;
    $graduation = 9.5;
    $beer = new Beer($name, $description, $price, $image, $ibu, $srm, $graduation);
    $beer->setId(3);
    array_push($cerverzas, $beer);
    $name = "Honey";
    $description = "";
    $price = 101.35;
    $image = "beer.jpg";
    $ibu = 21;
    $srm = 20;
    $graduation = 6.5;
    $beer = new Beer($name, $description, $price, $image, $ibu, $srm, $graduation);
    $beer->setId(4);
    array_push($cerverzas, $beer);
    return $cerverzas;
  }

  public function Update($object) {
  }
} ?>
